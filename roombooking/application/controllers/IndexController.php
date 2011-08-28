<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction() {
    	if ($this->_helper->user->isLoggedIn()) {
    		$user = $this->_helper->user->getUserData();
    		$hotel = User::getHotel($user);
    		
    		$pageModel = new ViewPageModel();
    		$pageModel->hotel = $hotel;
    		$this->view->pageModel = $pageModel;
    	} else {
    	   $this->_redirect("/user/login");
    	}
    }

    public function formsucceedAction() {
    }
}

