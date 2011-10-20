<?php
class EditRoomDiscount extends Zend_Form {
	
	private $roomDiscount;
	
	public function EditRoomDiscount($roomDiscount) {
		$this->roomDiscount = $roomDiscount;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("EditRoomDiscount");
		
		$element = new Zend_Form_Element_Hidden(RoomDiscount::ID);
		$element->setValue($this->roomDiscount->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Hidden(RoomDiscount::ROOM);
		$element->setValue(RoomDiscount::getRoom($this->roomDiscount)->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text("dummy");
		$element->setLabel("Room");
		$element->setValue(RoomDiscount::getRoom($this->roomDiscount)->name);
		$element->setAttrib("readonly", "readonly");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(RoomDiscount::RULE);
		$element->setLabel("Discount Rule");
		$element->setValue(RoomDiscount::getRule($this->roomDiscount)->rule_name);
		$element->setAttrib("readonly", "readonly");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(RoomDiscount::DISCOUNT);
		$element->setLabel("Discount");
		$element->setDescription("Discount in percentage");
		$element->setValue($this->roomDiscount->discount);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("OK");
		$this->addElement($element);
	}
}
?>