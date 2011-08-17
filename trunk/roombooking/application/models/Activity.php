<?php
require_once 'Zend/Db/Table/Abstract.php';

class Activity extends Zend_Db_Table_Abstract {
	
    const SEND_BOOKING_REQUEST = 1;
    const RESPOND_BOOKING_REQUEST = 2;
    
	protected $_name = 'activity';
	protected $_primary = 'id';
	
	protected $_referenceMap = array(
		'User' => array(
			'columns' => 'user_id',
			'refTableClass' => 'User',
			'refColumns' => 'id'	
		),
		'Type' => array(
			'columns' => 'type',
			'refTableClass' => 'ActivityType',
			'refColumns' => 'id'
		)
	);
	
	/**
	 * Find activity by id.
	 * 
	 * @param $id
	 * @return return activity
	 */
	public function findById($id) {
		return $this->find($id)->current();
	}
	
	/**
	 * Log a new activity. Only log one entry for user book status.
	 * 
	 * @param $type
	 * @param $user_id
	 * @param $object
	 * @param $created
	 */
	public static function logActivity($type, $user_id, $object, $created) {
		if ($type == Activity::USER_UPDATE_BOOK_STATUS) {
//			$userBook = new UserBook();
//			$userBookObj = $userBook->findById($object);
//			$invitation_id = $invitationResponse->invitation_id;
			$activity = Activity::findActivityByTypeObjectAndUser(Activity::USER_UPDATE_BOOK_STATUS, $object, $user_id);
			// if entry already exist, then delete it
			if (isset($activity)) {
				Activity::deleteActivityByTypeObjectAndUser(Activity::USER_UPDATE_BOOK_STATUS, $object, $user_id);
			}
		}
		
		$obj = new Activity();
		$row = $obj->createRow();
		$row->type = $type;
		$row->user_id = $user_id;
		$row->object = $object;
		$row->created = $created;
		$row->save();
	}
	
	/**
	 * Get user of activity.
	 * 
	 * @param $activity
	 */
	public static function getUser($activity) {
		return $activity->findParentRow("User");
	}
	
    /**
     * Get activity type.
     * 
     * @param $activity
     */
    public static function getType($activity) {
        return $activity->findParentRow("Type");
    }
	
	/**
	 * Find activity by type, object id and user id.
	 * 
	 * @param $type
	 * @param $object_id
	 * @param $invited_user_id
	 * @return return invitation response
	 */
	private static function findActivityByTypeObjectAndUser($type, $object_id, $invited_user_id) {
		$activity = new Activity();
		$select = $activity->select()->where('user_id=?', $invited_user_id)
		->where('object=?', $object_id)
		->where('type=?', $type);
		return $activity->fetchRow($select);
	}
	
	/**
	 * 
	 * @param $type
	 * @param $object_id
	 * @param $user_id
	 */
	private static function deleteActivityByTypeObjectAndUser($type, $object_id, $user_id) {
		$activity = Activity::findActivityByTypeObjectAndUser($type, $object_id, $user_id);
		if (isset($activity)) {
			$activity->delete();
		}
	}
	
	/**
	 * @return return activity string to be present on the site
	 */
	public static function toString($activity,$username='') {
		$config=Zend_Registry::get("config");
		$baseurl = $config->baseurl;
		$activityString = "";
		$user = User::findById($activity->user_id);
		switch($activity->type) {
			case Activity::PROFILE_POST:
				$userMessage = UserMessage::findById($activity->object);
				$activityString ="<span class='name'>".$username."</span> 给<strong>".UserMessage::getUser($userMessage)->username."(".UserMessage::getUser($userMessage)->email.")</strong>留了言.";
				break;
			case Activity::USER_MESSAGE:
				$userMessage = UserMessage::findById($activity->object);
				$activityString ="<span class='name'>".$username."</span> 给<strong>".UserMessage::getUser($userMessage)->username."(".UserMessage::getUser($userMessage)->email.")</strong>发送了一封站内信.";
				break;
			case Activity::INVITATION_COMMENT:
				$invitationMessage = InvitationMessage::findById($activity->object);
				$invitation = Invitation::findById($invitationMessage->invitation_id);
				$activityString ="<span class='name'>".$username."</span> 在".Invitation::getUser($invitation)->username."的邀请<strong>".$invitation->title."</strong>里发表了评论";
				break;
			case Activity::INVITATION_REPLY:
				$invitationResponse = InvitationResponse::findById($activity->object);
				$invitation = Invitation::findById($invitationResponse->invitation_id);
				
				switch($invitationResponse->response){
					case 1: $reply = "决定参加";break;
					case 0: $reply = "不参加"; break;
					default: $reply = "可能参加"; break;
				}
				$activityString ="<span class='name'>".$username."</span> ".$reply." <a href='".$baseurl."/user/index/uid/".Invitation::getUser($invitation)->id."' class='name'>".Invitation::getUser($invitation)->username."</a> 的邀请 <a href='".$baseurl."/invitation/view/iid/".$invitation->id."' class='name'>".$invitation->title."</a><span class='time'>".$activity->created.'</span>';
				break;
			case Activity::INVITATION_CREATE:
				$invitation = Invitation::findById($activity->object);
				$activityString = "<span class='name'>".$username."</span> 创建了一个新邀请 <a href='".$baseurl."/invitation/view/iid/".$invitation->id."' class='name'>".$invitation->title.'</a><span class="time">'.$invitation->created.'</span>';
				break;
			case Activity::ATTEND_INVITATION_REQUEST:
				$invitationList = InvitationList::findById($activity->object);
				$activityString = '你请求加入'.Invitation::getUser(InvitationList::getInvitation($invitationList))->username.'的邀请<strong>'.InvitationList::getInvitation($invitationList)->title.'</strong>, 等待对方回复';
				break;
			case Activity::APPROVE_ATTEND_REQUEST:
				$invitationList = InvitationList::findById($activity->object);
				$activityString = '你批准了<strong>'.InvitationList::getInvitedUser($invitationList)->email.'</strong>加入你的活动<strong>'.InvitationList::getInvitation($invitationList)->title.'</strong>';
				break;
		}
		return $activityString;
	}
}
?>