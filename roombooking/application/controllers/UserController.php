<?php
class UserController extends Zend_Controller_Action {
	
	private $user;
	private $hotel;
	
	public function init() {
		$this->user = new User();
		$this->hotel = new Hotel();
	}
	
	/**
	 * User login action.
	 */
	public function loginAction() {
		$next = $this->_getParam ( "next" );
		$form = new LoginForm ( $next );
		$this->view->form = $form;
		if ($this->getRequest ()->isPost ()) {
			if ($form->isValid ( $_POST )) {
                $userName = $form->getValue("username");
                $password = $form->getValue("password");
                $next = $form->getValue("next");
                $user = $this->user->findByLogin($userName, $password);
                $userProfile = new UserProfile();
                $userProfile->loggedInUser = $user;
                
                if (!empty($user)) {
                	// if hotel id is in the request, then complete user profile and go the first page
                	// else, show login continue page upon on user hotels.
                	$hotelId = $this->_getParam("hotel");
                	$hotel = $this->hotel->findById($hotelId);
                	if (empty($hotel)) {
	                	$hotels = User::getHotelsCanAdmin($user);
	                	if (count($hotels)>1) {
	                		$form = new LoginContinueForm($userName, $password, $hotels, $next);
	                		$this->view->form = $form;
	                	} else {
	                		if (count($hotels) == 1) {
	                			$userProfile->loggedInHotel = $hotels[0];
	                		}
		                	SessionUtil::setProperty(SessionUtil::USER_PROFILE, $userProfile);
		                	if (!empty($next)) {
		                		$this->_redirect($next);
		                	} else {
		                		$this->_redirect("/");
		                	}
	                	}
                	} else {
                		$userProfile->loggedInHotel = $hotel;
                		SessionUtil::setProperty(SessionUtil::USER_PROFILE, $userProfile);
		                if (!empty($next)) {
		                	$this->_redirect($next);
		                } else {
		                	$this->_redirect("/");
		                }
                	}
                }
			}
		}
	}
	
	public function logoutAction() {
		SessionUtil::setProperty(SessionUtil::USER_PROFILE, null);
		$this->_redirect("/");
		
	}
}
?>