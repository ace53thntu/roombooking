<?php
class Zend_View_Helper_LoggedInUser {
	protected $_view;
	function setView($view) { 
		$this->_view = $view; 
	} 
	
	function loggedInUser() {
//		$storage = new Zend_Auth_Storage_Session();
//        $data = $storage->read();
        $data = SessionUtil::getProperty(SessionUtil::USER_PROFILE);
//		$auth = Zend_Auth::getInstance();
//		
//		if($auth->hasIdentity()) {
//			return $auth->getIdentity();
//		}
		return $data->loggedInUser;
	}
}
?>