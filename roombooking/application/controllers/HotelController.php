<?php
class HotelController extends Zend_Controller_Action {
	
	private $hotel;
	
	public function init() {
		$this->hotel = new Hotel();
	}
	
	/**
	 * Add hotel action
	 */
	public function addAction() {
		if ($this->_helper->user->isLoggedIn()) {
            
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
}
?>