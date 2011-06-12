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
		$element->setValue($this->hotel->id);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text("name");
        $element->setLabel("Room name");
        $element->setRequired(true);
        $this->addElement($element);
        
		$element = new Zend_Form_Element_Text("key");
		$element->setLabel("Room category key");
		$element->setRequired(true);
		$this->addElement($element);
		
//		$element = new Zend_Form_Element_Hidden("total");
//		$element->setLabel("Total Amount");
//		$element->setDescription("Write number of total room of this type.");
//		$this->addElement($element);
        
        $element = new Zend_Form_Element_Text("available");
        $element->setLabel("Avaiable Room");
        $element->setDescription("Write number of avaible room of this type.");
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Textarea("description");
        $element->setLabel("Description");
        $element->setDescription("Description of the room.");
        $element->setAttrib('rows',4);
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Text("max_adults");
        $element->setLabel("Max Adults");
        $element->setDescription("Write number of person can live in.");
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("max_children");
        $element->setLabel("Max Children");
        $element->setDescription("Write number of children can live in.");
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Submit("Submit");
        $this->addElement($element);
	}
}
?>