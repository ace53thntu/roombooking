<?php
class HotelController extends Zend_Controller_Action {
	
	private $hotel;
	private $hotelUser;
	private $booking;
	private $user;
	private $room;
	
	public function init() {
		$this->hotel = new Hotel();
		$this->hotelUser = new HotelUser();
		$this->booking = new Booking();
		$this->user = new User();
		$this->room = new Room();
	}
	
	/**
	 * Add hotel action
	 */
	public function addAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$user = $this->_helper->user->getUserData();
			print_r($user);
            $form = new AddHotelForm(209, null);
            $this->view->form = $form;
            if ($this->getRequest ()->isPost ()) {
	            if ($form->isValid ( $_POST )) {
	            	$data = array(
	            	  Hotel::NAME => trim($form->getValue("name")),
	            	  Hotel::DESCRIPTION => trim($form->getValue("description")),
	            	  Hotel::ADDRESS => trim($form->getValue("address")),
	            	  Hotel::POST_ADDRESS => trim($form->getValue("post_address")),
	            	  Hotel::POST_CODE => trim($form->getValue("post_code")),
	            	  Hotel::CITY => $form->getValue("city"),
	            	  Hotel::CITY_PART => $form->getValue("city_part"),
	            	  Hotel::CHAIN => $form->getValue("chain"),
	            	  Hotel::PHONE1 => $form->getValue("phone1"),
	            	  Hotel::PHONE2 => $form->getValue("phone2"),
	            	  Hotel::FAX => $form->getValue("fax"),
	            	  Hotel::EMAIL => $form->getValue("email"),
	            	  Hotel::WEBSITE => $form->getValue("website"),
	            	  Hotel::CONTACT_NAME => $form->getValue(Hotel::CONTACT_NAME),
	            	  Hotel::CONTACT_TITLE => $form->getValue(Hotel::CONTACT_TITLE),
	            	  Hotel::CONTACT_EMAIL => $form->getValue(Hotel::CONTACT_EMAIL),
	            	  Hotel::CONTACT_PHONE => $form->getValue(Hotel::CONTACT_PHONE),
	            	  Hotel::CREATED => $this->_helper->generator->generateCurrentTime(),
	            	  Hotel::MODIFIED => $this->_helper->generator->generateCurrentTime()
	            	);
	            	
	            	$db = Zend_Registry::get("db");
	            	$db->beginTransaction();
	            	$hotel = $this->hotel->addHotel($data);
	            	$data = array(
	            	  HotelUser::HOTEL => $hotel->id,
	            	  HotelUser::USER => $user->id,
	            	  HotelUser::PERMISSION => Permission::ADMIN
	            	);
	            	$this->hotelUser->addHotelUser($data);
	            	$db->commit();
	            	$this->_redirect("/");
                }
            }
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	/**
	 * Process incoming booking request
	 */
	public function processincomingbookingAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$userProfile = $this->_helper->user->getUserProfile();
			$user = $userProfile->loggedInUser;
			$loggedInHotel = $userProfile->loggedInHotel;
			$booking = $this->booking->findById($this->_getParam("id"));
			if (empty($booking)) {
				throw new Exception("Booking id is missing!");
			}
            
            $this->view->booking = $this->_helper->booking->convertToBookingDTO($booking, $loggedInHotel);
            
            
//            if ($this->getRequest ()->isPost ()) {
//	            if ($form->isValid ( $_POST )) {
//	            	
//	            	$this->_redirect("/index/formsucceed");
//                }
//            }
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	public function processincomingrequestdoAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$userProfile = $this->_helper->user->getUserProfile();
			$user = $userProfile->loggedInUser;
			$loggedInHotel = $userProfile->loggedInHotel;
			$booking = $this->booking->findById($this->_getParam("id"));
			if (empty($booking)) {
				throw new Exception("Booking id is missing!");
			}
            $bookingStatus = $this->_getParam("bs");
            $db = Zend_Registry::get("db");
            $db->beginTransaction();
            $data = array(
            	Booking::ID => $booking->id,
            	Booking::STATUS => $bookingStatus
            );
            $this->booking->updateBooking($data);
            // TODO log activity, send notification email
            $db->commit();
            $this->_redirect("/index/formsucceed");
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
}
?>