<?php
class ProcessIncomingBooking extends Zend_Form {
	private $booking;
	
	public function ProcessIncomingBooking($booking) {
		$this->booking = $booking;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("ProcessIncomingBooking");
		
		$element = new Zend_Form_Element_Hidden(Booking::ID);
		$element->setValue($this->booking->id);
		$this->addElement($element);
		
	}
}
?>