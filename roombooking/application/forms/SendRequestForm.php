<?php

class SendRequestForm extends Zend_Form {
	
	private $selectedRoomIds;
	private $prices;
	private $discounts;
	private $fromUser;
	private $fromHotel;
	
	/**
	 * 
	 * @param $fromUser
	 * @param $fromHotel
	 * @param $selectedRoomIds
	 * @param $prices
	 * @param $discounts
	 */
	public function SendRequestForm($fromUser, $fromHotel, $selectedRoomIds, $prices, $discounts) {
		$this->selectedRoomIds = $selectedRoomIds;
		$this->prices = $prices;
		$this->discounts = $discounts;
		$this->fromUser = $fromUser;
		$this->fromHotel = $fromHotel;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setAction("submitbookingrequest");
		$this->setName("SendRequestForm");
		
		foreach ($this->selectedRoomIds as $key => $selectedRoomId) {
			if (isset($selectedRoomId)) {
				$defArr["roomId".$key] = "hidden";
				$valArr["roomId".$key] = $selectedRoomId;
			}
		}
		$element = new Zend_Form_SubForm("foo");
		$element->setElementsBelongTo("roomIds")
		->setElements($defArr);
		$element->populate($valArr);
		$this->addSubForm($element, "foo");

		$defArr=array();
		$valArr=array();
		foreach ($this->prices as $key => $price) {
			$defArr["price".$key] = "hidden";
			$valArr["price".$key] = $price;
		}
		$element = new Zend_Form_SubForm("foo1");
		$element->setElementsBelongTo("prices")
		->setElements($defArr);
		$element->populate($valArr);
		$this->addSubForm($element, "foo1");
		
		$defArr=array();
		$valArr=array();
		foreach ($this->discounts as $key => $discount) {
			$defArr["discount".$key] = "hidden";
			$valArr["discount".$key] = $discount;
		}
		$element = new Zend_Form_SubForm("foo2");
		$element->setElementsBelongTo("discounts")
		->setElements($defArr);
		$element->populate($valArr);
		$this->addSubForm($element, "foo2");
		
		$element = new Zend_Form_Element_Hidden(Booking::FROM_USER);
		$element->setValue($this->fromUser->id);
		$this->addElement($element);
		$element = new Zend_Form_Element_Hidden(Booking::FROM_HOTEL);
		$element->setValue($this->fromHotel->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Booking::FROM_DATE);
		$element->setLabel("From Date");
		$element->setDescription("Checkin date (2011-01-01)");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Booking::TO_DATE);
		$element->setLabel("To Date");
		$element->setDescription("Checkout date (2011-01-10)");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Booking::NUMBER_OF_ROOM);
		$element->setLabel("Number of rooms");
		$element->setDescription("Number of room to book");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Booking::NUMBER_OF_PERSON);
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