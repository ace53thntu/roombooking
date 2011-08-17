<?php
require_once 'Zend/Db/Table/Abstract.php';

class MailQueue extends Zend_Db_Table_Abstract {
	
	protected $_name = 'mail_queue';
	protected $_primary = 'id';
	
	protected $_referenceMap = array(
        'Type' => array(
            'columns' => 'type',
            'refTableClass' => 'activity_type',
            'refColumns' => 'id'
        )
    );
	
	/**
	 * Add email to queue.
	 * 
	 * @param $type
	 * @param $subject
	 * @param $sender
	 * @param $recipient
	 * @param $message
	 * @param $created
	 */
	public function addToQueue($type, $subject, $sender, $recipient, $message, $created) {
		$obj = $this->createRow();
		$obj->activity_type = $type;
		$obj->subject = $subject;
		$obj->sender = $sender;
		$obj->recipients = $recipient;
		$obj->message = $message;
		$obj->sent = false;
		$obj->created = $created;
		$id = $obj->save();
		return $id;
	}
	
	/**
	 * Find all unsent mail.
	 * 
	 * @return return all unsent mail
	 */
	public function findUnsentMails() {
		$select = $this->select()->where('sent=?', false);
		return $this->fetchAll($select);
	}
	
	/**
	 * Update mail status.
	 * 
	 * @param $id mail id
	 * @param $failMessage faile message, if any
	 * @param $sendTime
	 */
	public function updateStatus($id, $failMessage, $sendTime) {
		$obj = $this->find($id)->current();
		$obj->sent = true;
		$obj->error_message = $failMessage;
		$obj->send_time = $sendTime;
		$obj->save();
	}
}
?>