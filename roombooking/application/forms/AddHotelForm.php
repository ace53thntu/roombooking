<?php
class AddHotelForm extends Zend_Form {
	
	private $countryId;
	private $cityId;
	
	public function AddHotelForm($countryId, $cityId) {
		$this->countryId = $countryId;
		$this->cityId = $cityId;
		$this->__construct();
	}
	
	public function init () {
		$this->setMethod("POST");
		$this->setName("AddHotelForm");
		
		$element = new Zend_Form_Element_Text("name");
		$element->setLabel("Name");
		$element->setRequired(true);
		$element->addFilter(new Zend_Filter_HtmlEntities());
        $element->addFilter(new Zend_Filter_StripTags());
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Textarea("description");
		$element->setLabel("Description");
		$element->setRequired(true);
		$element->addFilter(new Zend_Filter_HtmlEntities());
        $element->addFilter(new Zend_Filter_StripTags());
        $element->setAttrib('rows',4);
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("address");
        $element->setLabel("Address");
        $element->setRequired(true);
        $element->addFilter(new Zend_Filter_HtmlEntities());
        $element->addFilter(new Zend_Filter_StripTags());
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("post_address");
        $element->setLabel("Post Address");
        $element->setRequired(true);
        $element->addFilter(new Zend_Filter_HtmlEntities());
        $element->addFilter(new Zend_Filter_StripTags());
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("post_code");
        $element->setLabel("PostCode");
        $element->setRequired(true);
        $element->addFilter(new Zend_Filter_HtmlEntities());
        $element->addFilter(new Zend_Filter_StripTags());
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Select("country");
        $element->setLabel("Country");
        $element->addMultiOption(0, "-- Select country --");
        $element->addMultiOptions(Country::getAllCountryAsArray());
        if (!empty($this->countryId)) {
            $element->setValue($this->countryId);
        }
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Select("city");
        $element->setLabel("City");
        $element->addMultiOption(0, "-- Select city --");
        $element->addMultiOptions(Country::getTopCityByCountryAsArray($this->countryId));
        if (!empty($this->cityId)) {
            $element->setValue($this->cityId);
        }
        $element->setRegisterInArrayValidator(false);
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Select("city_part");
        $element->setLabel("City Part");
        $element->addMultiOptions(
        array("center" => "Center", "east" => "East", "west" => "West", "north"=>"North", "south"=>"South")
        );
        $element->setRegisterInArrayValidator(false);
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Submit("Submit");
        $this->addElement($element);
	}
}
?>