<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction() {
    	if ($this->_helper->user->isLoggedIn()) {
    	   
    	} else {
    	   $this->_redirect("/user/login");
    	}
    }


}

