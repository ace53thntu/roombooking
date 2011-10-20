<?php
class BookingController extends Zend_Controller_Action {
	
	private $user;
	private $booking;
	private $room;
	private $hotel;
	
	public function init() {
		$this->user = new User();
		$this->booking = new Booking();
		$this->room = new Room();
		$this->hotel = new Hotel();
	}
	
	/**
	 * Mark booking status as delivered, only valid for ACCEPTED booking.
	 */
	public function processacceptedAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$userProfile = $this->_helper->user->getUserProfile();
			$user = $userProfile->loggedInUser;
			$loggedInHotel = $userProfile->loggedInHotel;
			$booking = $this->booking->findById($this->_getParam("id"));
			if (empty($booking)) {
				throw new Exception("Booking id is missing!");
			}
			
			$this->view->booking = $this->convertToBookingDTO($booking);
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	/**
	 * Deliver customer action, when target hotel accepted booking request.
	 */
	public function delivercustomerAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$userProfile = $this->_helper->user->getUserProfile();
			$user = $userProfile->loggedInUser;
			$loggedInHotel = $userProfile->loggedInHotel;
			$booking = $this->booking->findById($this->_getParam("id"));
			if (empty($booking)) {
				throw new Exception("Booking id is missing!");
			}
			
			$db = Zend_Registry::get("db");
		    $db->beginTransaction();
		    if ($booking->status != BookingStatus::ACCEPTED) {
		      	throw new Exception("Booking status must be ACCEPTED to continue this action");
		    }
		    $data = array(
		    Booking::ID => $booking->id,
		       	Booking::STATUS => BookingStatus::DELIVERED
		    );
		    $this->booking->updateBooking($data);
		    // TODO log activity, send notification email
		    $db->commit();
		    $this->_redirect("/index/formsucceed");
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	/**
	 * 
	 */
	public function processdeliveredAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$userProfile = $this->_helper->user->getUserProfile();
			$user = $userProfile->loggedInUser;
			$loggedInHotel = $userProfile->loggedInHotel;
			$booking = $this->booking->findById($this->_getParam("id"));
			if (empty($booking)) {
				throw new Exception("Booking id is missing!");
			}
			
			$this->view->booking = $this->convertToBookingDTO($booking);
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	/**
	 * Confirm delivered customer action,
	 * recalculate number of room in this step.
	 */
	public function confirmdeliveredcustomerAction() {
		if ($this->_helper->user->isLoggedIn()) {
			$userProfile = $this->_helper->user->getUserProfile();
			$user = $userProfile->loggedInUser;
			$loggedInHotel = $userProfile->loggedInHotel;
			$booking = $this->booking->findById($this->_getParam("id"));
			if (empty($booking)) {
				throw new Exception("Booking id is missing!");
			}
			if ($booking->status != BookingStatus::DELIVERED) {
				throw new Exception("Booking status has to be DELIVERED to proceed this action!");
			}
			
			$db = Zend_Registry::get("db");
			$db->beginTransaction();
			$data = array(
				Booking::ID => $booking->id,
				Booking::STATUS => BookingStatus::CONFIRMED
			);
			$this->booking->updateBooking($data);
			$room = Booking::getRoom($booking);
			$data = array(
				Room::ID => $room->id,
				Room::AVAILABLE => $room->available-$booking->number_of_room
			);
			$this->room->updateRoom($data);
			$db->commit();
			$this->_redirect("/index/formsucceed");
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	/**
	 * Convert from booking to bookingDTO.
	 * 
	 * @param $booking
	 */
	private function convertToBookingDTO($booking) {
		$bookingDTO = new BookingDTO();
		$bookingDTO->id = $booking->id;
		$bookingDTO->fromHotel = $this->hotel->findById($booking->from_hotel);
		$bookingDTO->fromUser = $this->user->findById($booking->from_user);
		$bookingDTO->toHotel = $this->hotel->findById($booking->to_hotel);
		$bookingDTO->room = $this->room->findById($booking->room_id);
		$bookingDTO->fromDate = $booking->from_date;
		$bookingDTO->toDate = $booking->to_date;
		$bookingDTO->numberOfRoom = $booking->number_of_room;
		return $bookingDTO;
	}
}
?>