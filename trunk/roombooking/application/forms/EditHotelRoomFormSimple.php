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
		
		$element = new Zend_Form_Element_Text("available");
		$element->setLabel("Free Room");
		$element->setRequired(true);
		$element->setValue($this->room->available);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text("discount");
		$element->setLabel("Discount");
		$element->setValue(Room::getDiscount($this->room));
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text("commission");
		$element->setLabel("Commission");
		$element->setValue(Room::getCommission($this->room));
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("Ok");
		$this->addElement($element);
	}
}
?>