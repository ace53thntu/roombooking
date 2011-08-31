<?php
class LoginContinueForm extends Zend_Form {
	
	private $userName;
	private $password;
	private $hotels;
    private $next;
    
    public function LoginContinueForm($userName, $password, $hotels, $next=null) {
    	$this->userName = $userName;
    	$this->password = $password;
    	$this->hotels = $hotels;
        $this->next = $next;
        $this->__construct();
    }
    
    public function init() 
    {   
        $this->setName('LsoginContinueForm');        
        $this->setMethod('post');
        $this->setAction('login');
        
        $element = new Zend_Form_Element_Text('username');
        $element->setLabel('Username:');
        $element->setValue($this->userName);
        $element->setAttrib("readonly", "readonly");
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Hidden('password');        
        $element->setValue($this->password);
        $this->addElement($element);
        
        $hotelsArr = array();
        foreach ($this->hotels as $hotel) {
        	$hotelsArr[$hotel->id] = $hotel->name;
        }
        $element = new Zend_Form_Element_Select('hotel');
        $element->setLabel("Hotel");
        $element->setRequired(true);
        $element->addMultiOption(0, "Select Hotel");
        $element->addMultiOptions($hotelsArr);
        $this->addElement($element);
        
        $this->addElement('hidden', 'next', array(
        'value' => $this->next,
        ));
        
        $login = $this->createElement('submit','login');
        $login->setIgnore(true);
        $this->addElement($login);
    }
}
?>