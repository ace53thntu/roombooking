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
		
		$element = new Zend_Form_Element_Hidden(RoomDiscount::ROOM);
		$element->setValue($this->room->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text("available");
		$element->setLabel("Free Room");
		$element->setRequired(true);
		$element->setValue($this->room->available);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Hidden(RoomDiscount::RULE);
		$element->setValue(RoomDiscountRule::UNKNOWN);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(RoomDiscount::DISCOUNT);
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