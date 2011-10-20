<?php

class IndexController extends Zend_Controller_Action {

	private $hotel;
	
    public function init()
    {
    	$this->hotel = new Hotel();
        /* Initialize action controller here */
    }

    public function indexAction() {
    	if ($this->_helper->user->isLoggedIn()) {
    		$userProfile = $this->_helper->user->getUserProfile();
			$user = $userProfile->loggedInUser;
			$hotel = $userProfile->loggedInHotel;
    		
    		$pageModel = new ViewPageModel();
    		$pageModel->hotel = $this->hotel->findById($hotel->id);
    		$this->view->pageModel = $pageModel;
    		
    		$config = Zend_Registry::get("config");
    		$pageSize = $config->bookingOverview->pageSize;
    		
    		$this->view->roomListPaginator = $this->_helper->paginator( $this->_getParam ( 'page', 1 ), $pageSize, $pageModel->getHotelRooms() );
    		$this->view->bookingOverviewPaginator = $this->_helper->paginator( $this->_getParam ( 'page', 1 ), $pageSize, $pageModel->getBookingActivities() );
    	} else {
    	   $this->_redirect("/user/login");
    	}
    }

    public function formsucceedAction() {
    }
}

