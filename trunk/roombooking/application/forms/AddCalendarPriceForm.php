<?php
class AddCalendarPriceForm extends Zend_Form {
	
	private $room;
	
	public function AddCalendarPriceForm($room) {
		$this->room = $room;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("AddCalendarPriceForm");
		
		$element = new Zend_Form_Element_Hidden(CalendarPrice::ROOM);
		$element->setValue($this->room->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select(CalendarPrice::CALENDAR);
		$element->setLabel("Calendar");
		$element->setDescription("Choose a calendar");
		$element->addMultiOption(0, "-- Select calendar --");
		$element->addMultiOptions(Calendar::getCalendarAsArray());
		$element->setRequired(true);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(CalendarPrice::PRICE);
		$element->setLabel("Price");
		$element->setDescription("The cost of room during calendar period");
		$element->setRequired(true);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("Add");
		$this->addElement($element);
	}
}
?>