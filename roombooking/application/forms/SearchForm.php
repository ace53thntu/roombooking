<?php
class SearchForm extends Zend_Form {
	
	private $hotel;
	private $room;
	
	public function SearchForm($hotel, $room) {
		$this->hotel = $hotel;
		$this->room = $room;
		$this->__construct();
	}
	
	public function init() {
		$this->setMethod("POST");
		$this->setName("SearchForm");
		
		$element = new Zend_Form_Element_Hidden("room_id");
		$element->setValue($this->room->id);
		$this->addElement($element);
		
		$config = Zend_Registry::get("config");
		$element = new Zend_Form_Element_Hidden("baseUrl");
		$element->setValue($config->baseurl);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select(Hotel::CITY_PART);
		$element->setLabel("City part");
		$element->setDescription("Select city part");
		$element->addMultiOption(0, "-- Select city part --");
		$arr = array(
			"center" => "Center",
			"north" => "North",
			"south" => "South",
			"west" => "West",
			"east" => "East"
		);
		$element->addMultiOptions($arr);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select(Room::HOTEL);
		$element->setLabel("Hotel");
		$element->addMultiOption(0, "-- Select Hotel --");
//		$element->addMultiOptions(Hotel::getHotelAsArray());
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select("room_id");
		$element->setLabel("Room");
		$element->addMultiOption(0, "-- Select Room --");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("Search");
		$this->addElement($element);
	}
}
?>