<?php
class AddHotelForm extends Zend_Form {
	
	public function init () {
		$this->setMethod("POST");
		$this->setName("AddHotelForm");
		
		$element = new Zend_Form_Element_Text("name");
		
	}
}
?>