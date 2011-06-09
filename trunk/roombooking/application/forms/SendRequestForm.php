<?php
class SendRequestForm extends Zend_Form {
	
	private $hotel;
	private $room;
	
	public function SendRequestForm($hotel, $room) {
		$this->hotel = $hotel;
		$this->room = $room;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("SendRequestForm");
		
		$element = new Zend_Form_Element_Hidden("room_id");
		$element->setValue($this->room->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("Send");
		$this->addElement($element);
	}
}
?>