<?php

class SendRequestForm extends Zend_Form {
	
	private $selectedRoomIds;
	private $fromUser;
	
	public function SendRequestForm($fromUser, $selectedRoomIds) {
		$this->selectedRoomIds = $selectedRoomIds;
		$this->fromUser = $fromUser;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("SendRequestForm");
		
		foreach ($this->selectedRoomIds as $selectedRoomId) {
			$element = new Zend_Form_Element_Hidden("roomIds[]");
			$element->setValue($selectedRoomId);
			$this->addElement($element);
		}
		
		$element = new Zend_Form_Element_Hidden(Booking::FROM_USER);
		$element->setValue($this->fromUser->id);
		$this->addElement($element);
		
		$fromHotel = User::getHotel($this->fromUser);
		$element = new Zend_Form_Element_Hidden(Booking::FROM_HOTEL);
		$element->setValue($fromHotel->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Booking::FROM_DATE);
		$element->setLabel("From Date");
		$element->setDescription("Checkin date (2011-01-01)");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Booking::TO_DATE);
		$element->setLabel("To Date");
		$element->setDescription("Checkout date (2011-01-10)");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Booking::NUMER_OF_PERSON);
		$element->setLabel("Number of person");
		$element->setDescription("Number of person to live in");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Booking::ARRIVAL_TIME);
		$element->setLabel("Arrival Date");
		$element->setDescription("Customer arrival date");
		$this->addElement($element);
		
		
		
		$element = new Zend_Form_Element_Text(Customer::FIRST_NAME);
		$element->setLabel("First Name");
		$element->setDescription("Customer's first name");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Customer::LAST_NAME);
		$element->setLabel("Last Name");
		$element->setDescription("Customer's last name");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Customer::SOCIAL_SECURITY_NUMBER);
		$element->setLabel("Social Security Number");
		$element->setDescription("Customer's social security number");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Customer::PHONE);
		$element->setLabel("Phone");
		$element->setDescription("Customer's phone number");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("Send");
		$this->addElement($element);
	}
}
?>