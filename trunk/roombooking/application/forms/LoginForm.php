<?php
class LoginForm extends Zend_Form 
{
    private $next;
    
    public function LoginForm($next=null) {
        $this->next = $next;
        $this->__construct();
    }
    
    public function init() 
    {   
        $this->setName('loginForm');        
        $this->setMethod('post');
        $this->setAction('login');
        
        $element = new Zend_Form_Element_Text('username');
        $element->setLabel('Username:');
        $element->setRequired(true);
        $element->addFilter(new Zend_Filter_StripTags());
        $element->addValidator('NotEmpty');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Password('password');        
        $element->setLabel('Password:');
        $element->setRequired(true);
        $element->addValidator(new Zend_Validate_StringLength(6,20));
        $element->addFilter(new Zend_Filter_HtmlEntities());
        $element->addFilter(new Zend_Filter_StripTags());
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