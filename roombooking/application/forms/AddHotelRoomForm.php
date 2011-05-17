<?php
class AddHotelRoomForm extends Zend_Form {
	
	private $hotel;
	
	public function AddHotelRoomForm($hotel) {
		$this->hotel = $hotel;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("AddHotelRoomForm");
		
		$element = new Zend_Form_Element_Hidden("hotel_id");
		$element->setValue($hotel->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select("type_id");
		$element->setLabel("Room Type");
		$element->setMultiOptions();
		
		$element = new Zend_Form_Element_Text("total");
		$element->setLabel("Total Amount");
		$this->addElement($element);
		
	}
}
?>