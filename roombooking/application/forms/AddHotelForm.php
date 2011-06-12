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
        
        $element = new Zend_Form_Element_Select("chain");
        $element->setLabel("Chain");
        $element->addMultiOptions(
        array(
        HotelChain::NONE=>HotelChain::NONE, 
        HotelChain::HILTON=>HotelChain::HILTON, 
        HotelChain::ELITE=>HotelChain::ELITE, 
        HotelChain::SWEDEN=>HotelChain::SWEDEN, 
        HotelChain::FIRST=>HotelChain::FIRST,
        HotelChain::RICA=>HotelChain::RICA,
        HotelChain::CLARION=>HotelChain::CLARION,
        HotelChain::NORDIC=>HotelChain::NORDIC,
        HotelChain::BEST_WESTERN=>HotelChain::BEST_WESTERN,
        HotelChain::OTHER=>HotelChain::OTHER
        )
        );
        $element->setRegisterInArrayValidator(false);
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("phone1");
        $element->setLabel("Telephone");
        $element->setRequired(true);
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("phone2");
        $element->setLabel("Telephone 2");
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("fax");
        $element->setLabel("Fax");
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("email");
        $element->setLabel("Email");
        $element->setRequired(true);
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("website");
        $element->setLabel("WWW");
        $this->addElement($element);
        
        // contact information
        $element = new Zend_Form_Element_Text("contact_name");
        $element->setLabel("Contact Name");
        $element->setRequired(true);
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("contact_title");
        $element->setLabel("Title");
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("contact_phone");
        $element->setLabel("Phone");
        $element->setRequired(true);
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text("contact_email");
        $element->setLabel("Email");
        $element->setRequired(true);
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Submit("Submit");
        $this->addElement($element);
	}
}
?>