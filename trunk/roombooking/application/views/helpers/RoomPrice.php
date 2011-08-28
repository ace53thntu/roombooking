<?php
class Zend_View_Helper_RoomPrice {
	
	protected $_view;
	function setView($view) { 
		$this->_view = $view; 
	}
	
	public function roomPrice($roomDTO) {
		$ret = "";
		$table = new Room();
		$room = $table->findById($roomDTO->id);
		$rates = Room::getRoomRates($room);
		foreach ($rates as $rate) {
			$ret.= Rate::getRateName($rate)->key.": ".$rate->person_number." pers, ".$rate->price."<br/>";
		}
		
		$calendarPrices = Room::getCalendarPrices($room);
		foreach ($calendarPrices as $calendarPrice) {
			$ret.=CalendarPrice::getCalendar($calendarPrice)->name.": ".$calendarPrice->price."<br/>";
		}
		
		$ret.="Discount: ".Room::getDiscount($room)."%<br/>";
		$ret.="Commission: ".Room::getCommission($room)."%<br/>";
		return $ret;
	}
}
?>