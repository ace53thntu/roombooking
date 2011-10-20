<?php
class AddRoomDiscount extends Zend_Form {
	
	private $room;
	
	public function AddRoomDiscount($room) {
		$this->room = $room;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("AddRoomDiscount");
		
		$element = new Zend_Form_Element_Hidden(RoomDiscount::ROOM);
		$element->setValue($this->room->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select(RoomDiscount::RULE);
		$element->addMultiOption(0, "Select Discount Rule");
		$element->addMultiOptions(RoomDiscountRule::getRoomDiscountRuleAsArray());
		$element->setLabel("Discount Rule");
		$element->setDescription("Discount rule define which condition should apply this discount rule");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(RoomDiscount::DISCOUNT);
		$element->setLabel("Discount");
		$element->setDescription("Discount in percentage");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("OK");
		$this->addElement($element);
	}
}
?>