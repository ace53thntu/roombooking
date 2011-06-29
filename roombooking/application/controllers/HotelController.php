<?php
class HotelController extends Zend_Controller_Action {
	
	private $hotel;
	
	public function init() {
		$this->hotel = new Hotel();
	}
	
	/**
	 * Add hotel action
	 */
	public function addAction() {
		if ($this->_helper->user->isLoggedIn()) {
            $form = new AddHotelForm(209, null);
            $this->view->form = $form;
            
            if ($this->getRequest ()->isPost ()) {
	            if ($form->isValid ( $_POST )) {
	            	$data = array(
	            	  Hotel::NAME => trim($form->getValue("name")),
	            	  Hotel::DESCRIPTION => trim($form->getValue("description")),
	            	  Hotel::ADDRESS => trim($form->getValue("address")),
	            	  Hotel::POST_ADDRESS => trim($form->getValue("post_address")),
	            	  Hotel::POST_CODE => trim($form->getValue("post_code")),
	            	  Hotel::CITY => $form->getValue("city"),
	            	  Hotel::CITY_PART => $form->getValue("city_part"),
	            	  Hotel::CHAIN => $form->getValue("chain"),
	            	  Hotel::PHONE1 => $form->getValue("phone1"),
	            	  Hotel::PHONE2 => $form->getValue("phone2"),
	            	  Hotel::FAX => $form->getValue("fax"),
	            	  Hotel::EMAIL => $form->getValue("email"),
	            	  Hotel::WEBSITE => $form->getValue("website"),
	            	  Hotel::CONTACT_NAME => $form->getValue(Hotel::CONTACT_NAME),
	            	  Hotel::CONTACT_TITLE => $form->getValue(Hotel::CONTACT_TITLE),
	            	  Hotel::CONTACT_EMAIL => $form->getValue(Hotel::CONTACT_EMAIL),
	            	  Hotel::CONTACT_PHONE => $form->getValue(Hotel::CONTACT_PHONE),
	            	  Hotel::CREATED => $this->_helper->generator->generateCurrentTime(),
	            	  Hotel::MODIFIED => $this->_helper->generator->generateCurrentTime()
	            	);
	            	
	            	$db = Zend_Registry::get("db");
	            	$db->beginTransaction();
	            	$this->hotel->addHotel($data);
	            	$db->commit();
                }
            }
		} else {
			$this->_redirect( "/user/login?next=".urlencode($this->_helper->generator->getCurrentURI()) );
		}
	}
	
	
}
?>