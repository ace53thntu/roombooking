<?php
class PageModel {
	
	public $loggedInUser;
	
	/**
	 * Get loggedIn user, if exist.
	 * 
	 * @return return user object
	 */
	public function getLoggedInUser() {
		return SessionUtil::getProperty("userData");
	}
}
?>