<?php

class SendRequestForm extends Zend_Form {
	
	private $selectedRoomIds;
	public function SendRequestForm($selectedRoomIds) {
		$this->selectedRoomIds = $selectedRoomIds;
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("SendRequestForm");
		
		$element = new Zend_Form_Element_Hidden("roomIds[]");
		$element->setValue($this->selectedRoomIds);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("Send");
		$this->addElement($element);
	}
}
?>