<?php
class AddRoomRateForm extends Zend_Form {
	
	private $room;
	
	public function AddRoomRateForm($room) {
		$this->room = $room;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("AddRoomRateForm");
		
		$element = new Zend_Form_Element_Hidden(Rate::ROOM);
		$element->setValue($this->room->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select(Rate::RATE);
		$element->setLabel("Rate Name");
		$element->setDescription("Choose rate name");
		$element->addMultiOption(0, "-- Select rate name --");
		$element->addMultiOptions(RateName::getRateNameAsArray());
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Rate::PERSON_NUMBER);
		$element->setLabel("Number of persons");
		$element->setDescription("Fill in how many people gonna stay");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Rate::PRICE);
        $element->setLabel("Price");
        $element->setDescription("Price of room");
        $this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("Add");
		$this->addElement($element);
	}
}
?>