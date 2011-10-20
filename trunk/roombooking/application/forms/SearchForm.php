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
		
		if (isset($this->room)) {
			$element = new Zend_Form_Element_Hidden("room_id");
			$element->setValue($this->room->id);
			$this->addElement($element);
		}
		
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
		
		$element = new Zend_Form_Element_Text(Room::MAX_ADULTS);
		$element->setLabel("Number of adults");
		$element->setDescription("Max number of adults per room");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text(Rate::PRICE);
		$element->setLabel("Price");
		$element->setDescription("Max price of room");
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select(Room::MAX_CHILDREN);
		$element->setLabel("Number of children");
		$element->setDescription("Max number of children");
		$options = array(
			0=>0,
			1=>1,
			2=>2,
			3=>3,
		);
		$element->addMultiOptions($options);
		$this->addElement($element);
		
//		$element = new Zend_Form_Element_Select(Room::HOTEL);
//		$element->setLabel("Hotel");
//		$element->addMultiOption(0, "-- Select Hotel --");
////		$element->addMultiOptions(Hotel::getHotelAsArray());
//		$this->addElement($element);
//		
//		$element = new Zend_Form_Element_Select("room_id");
//		$element->setLabel("Room");
//		$element->addMultiOption(0, "-- Select Room --");
//		$this->addElement($element);
		
		$element = new Zend_Form_Element_Submit("Search");
		$this->addElement($element);
	}
}
?>