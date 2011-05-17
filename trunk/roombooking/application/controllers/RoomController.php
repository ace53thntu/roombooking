<?php
class RoomController extends Zend_Controller_Action {
	
	private $hotel;
	public function init() {
		$this->hotel = new Hotel();
	}
	
	/**
	 * Add room action.
	 */
	public function addAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$user = $this->_helper->user->getUserData();
			$hotel = User::getHotel($user);
            if (!empty($hotel)) {
	            $form = new AddHotelRoomForm($hotel);
	            $this->view->form = $form;
	            
	            if ($this->getRequest ()->isPost ()) {
	                if ($form->isValid ( $_POST )) {
	                	
	                }
	            }
			} else {
				throw new Zend_Exception("No hotel specified!");
				
			}
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
}
?>