<?php
class RoomController extends Zend_Controller_Action {
	
	/**
	 * Add room action.
	 */
	public function addAction() {
	    if ($this->_helper->user->isLoggedIn()) {
	    	$user = $this->_helper->user->getUserData();
	    	$hotel = User::getHotel($user);
            $form = new AddHotelRoomForm($hotel);
	    	
            $this->view->form = $form;
        } else {
            $this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
        }
	}
}
?>