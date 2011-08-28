<?php
class Zend_View_Helper_BookingOverview {
	protected $_view;
	function setView($view) { 
		$this->_view = $view; 
	} 
	
	/**
	 * Booking dto objects array.
	 * 
	 * @param $bookings
	 */
	public function bookingOverview($bookings) {
		$this->_view->bookings = $bookings;
        $out = $this->_view->render('/hotel/BookingOverview.phtml');
        return $out;
	}
}
?>