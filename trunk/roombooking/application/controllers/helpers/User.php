<?php

class Zend_Controller_Action_Helper_User extends Zend_Controller_Action_Helper_Abstract {
	
	public function direct() {
		
	}
	
	/**
	 * Check if user is already loggin.
	 */
	public function isLoggedIn() {
//		$storage = new Zend_Auth_Storage_Session();
//		$data = $storage->read();
        $data = SessionUtil::getProperty(SessionUtil::USER_PROFILE);
		return isset($data->loggedInUser) && isset($data->loggedInHotel);
	}
	
	/**
	 * Check the given user info is same as the login session data.
	 * Then we can say this user is logged in
	 * 
	 * @param $user_id
	 * @return return true if given user has logged in
	 */
	public function userHasLoggedIn($user_id) {
		$hasLoggedIn = false;
//		$storage = new Zend_Auth_Storage_Session();
//		$data = $storage->read();
        $data = SessionUtil::getProperty(SessionUtil::USER_PROFILE);
		if ($data->loggedInUser->id == $user_id) {
			$hasLoggedIn = true;
		}
		return $hasLoggedIn;
	}
	
	/**
	 * Return user data from session.
	 */
	public function getUserData() {
//		$storage = new Zend_Auth_Storage_Session();
//		$data = $storage->read();
        $data = SessionUtil::getProperty(SessionUtil::USER_PROFILE);
		return $table->findById($data->loggedInUser);
	}
	
	/**
	 * Return user profile.
	 * 
	 * @return user profile
	 */
	public function getUserProfile() {
		$data = SessionUtil::getProperty(SessionUtil::USER_PROFILE);
		return $data;
	}
	
	/**
	 * @param $user user
	 * @return return username if any, otherwise, return email
	 */
	public function getUserPresentName($user) {
		if (isset($user->name) && $user->name != '') {
			return $user->name;
		} else {
			return $user->email;
		}
	}
	
	/**
	 * Get user activate date.
	 * 
	 * @param $user
	 */
	public function getActivateDate($user) {
		if (isset($user->activated) && $user->activated != '') {
			return $user->activated;
		} else {
			return "Not specified";
		}
	}
	
	/**
	 * 
	 * @param $user
	 */
	public function getUserViewCity() {
		$table = new User();
		
//		$viewLocationFromReq = SessionUtil::getProperty("vl");
//		if (empty($viewLocationFromReq)) {
			if ($this->isLoggedIn()) {
	            $user = $table->findById($this->getUserData()->id);
	            $cityId = User::getTopCity($user)->id;
	        } else {
	            $cityId = SessionUtil::getProperty(Constant::KEY_CITY_ID);
	            if (empty($cityId)) {
	                $cityId = 1;
	            }
	        }
//		} else {
//			$cityId = City::getTopCity($viewLocationFromReq)->id;
//			SessionUtil::setProperty("vl", null);
//		}
		return $cityId;
	}
}
?>