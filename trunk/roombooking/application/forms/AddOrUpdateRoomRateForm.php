<?php
class AddOrUpdateRoomRateForm extends Zend_Form {
	
	private $room;
	private $rate;
	
	public function AddOrUpdateRoomRateForm($room, $rate=null) {
		$this->room = $room;
		$this->rate = $rate;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("AddOrUpdateRoomRateForm");
		
		$element = new Zend_Form_Element_Hidden(Rate::ROOM);
		$element->setValue($this->room->id);
		$this->addElement($element);
		
		if (!empty($this->rate)) {
			$element = new Zend_Form_Element_Hidden(Rate::ID);
			$element->setValue($this->rate->id);
			$this->addElement($element);
		}
		
		$element = new Zend_Form_Element_Select(Rate::RATE);
		$element->setLabel("Rate Name");
		$element->setDescription("Choose rate name");
		$element->addMultiOption(0, "-- Select rate name --");
		$element->addMultiOptions(RateName::getRateNameAsArray());
		if (!empty($this->rate)) {
			$element->setValue($this->rate->rate_name);
			$element->setAttrib("readonly", "readonly");
		}
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Rate::PERSON_NUMBER);
		$element->setLabel("Number of persons");
		$element->setDescription("Fill in how many people gonna stay");
		if (!empty($this->rate)) {
			$element->setValue($this->rate->person_number);
			$element->setAttrib("readonly", "readonly");
		}
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Rate::PRICE);
        $element->setLabel("Price");
        $element->setDescription("Price of room");
		if (!empty($this->rate)) {
			$element->setValue($this->rate->price);
		}
        $this->addElement($element);
		
//        $element = new Zend_Form_Element_Text(Rate::DISCOUNT);
//        $element->setLabel("Discount");
//        $element->setDescription("Discount in percentage");
//		if (!empty($this->rate)) {
//			$element->setValue($this->rate->discount);
//		}
//        $this->addElement($element);
        
//        $element = new Zend_Form_Element_Select(CalendarPriceDiscount::CALENDAR);
//        $element->setLabel("Special Season");
//        $element->setDescription("Season special price offer, e.g. Summer price");
//        $element->addMultiOption(0, "Select speical period");
//        $element->addMultiOptions(Calendar::getCalendarAsArray());
//		if (!empty($this->rate)) {
//			$element->setValue($this->rate->calendar_id);
//		}
//        $this->addElement($element);
//        
//        $element = new Zend_Form_Element_Text("calendar_price_discount");
//        $element->setLabel("Speical Season Discount");
//        $element->setDescription("Discount in percentage");
//		if (!empty($this->rate->calendar_id)) {
//			$element->setValue($this->rate->calendar_price_discount);
//		}
//        $this->addElement($element);
        
        $element = new Zend_Form_Element_Textarea(Rate::COMMENT);
        $element->setLabel("Comment");
        $element->setAttrib("rows", 5);
        $element->setAttrib("cols", 30);
		if (!empty($this->rate->comment)) {
			$element->setValue($this->rate->comment);
		}
        $this->addElement($element);
        
//        $this->addDisplayGroup(array(CalendarPriceDiscount::CALENDAR, "calendar_price_discount"), "calendarPriceDiscount");
        
		$element = new Zend_Form_Element_Submit("OK");
		$this->addElement($element);
	}
}
?>