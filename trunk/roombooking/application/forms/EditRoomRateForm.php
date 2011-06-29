<?php
class EditRoomRateForm extends Zend_Form {
	
	private $room;
	private $rate;
	
	public function EditRoomRateForm($room, $rate) {
		$this->room = $room;
		$this->rate = $rate;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("EditRoomRateForm");
		
		$element = new Zend_Form_Element_Hidden(Rate::ROOM);
		$element->setValue($this->room->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Hidden(Rate::ID);
		$element->setValue($this->rate->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select(Rate::RATE);
		$element->setLabel("Rate Name");
		$element->setDescription("Choose rate name");
		$element->addMultiOption(0, "-- Select rate name --");
		$element->addMultiOptions(RateName::getRateNameAsArray());
		$element->setValue($this->rate->rate_name);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Rate::PERSON_NUMBER);
		$element->setLabel("Number of persons");
		$element->setDescription("Fill in how many people gonna stay");
		$element->setValue($this->rate->person_number);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Rate::PRICE);
        $element->setLabel("Price");
        $element->setDescription("Price of room");
        $element->setValue($this->rate->price);
        $this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("Edit");
		$this->addElement($element);
	}
}
?>