<?php
class EditHotelRoomFormSimple extends Zend_Form {
	
	private $hotel;
	private $room;
	
	public function EditHotelRoomFormSimple($hotel, $room) {
		$this->hotel = $hotel;
		$this->room = $room;
		$this->__construct();
	}
	
	public function init () {
		
		$this->setMethod("POST");
		$this->setName("EditHotelRoomFormSimple");
		
		$element = new Zend_Form_Element_Hidden("room_id");
		$element->setValue($this->room->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text("avaialbe");
		$element->setLabel("Free Room");
		$element->setRequired(true);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text("discount");
		$element->setLabel("Discount");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text("commission");
		$element->setLabel("Commission");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("Ok");
		$this->addElement($element);
	}
}
?>