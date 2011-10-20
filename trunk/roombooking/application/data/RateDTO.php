<?php
class RateDTO {
	
	public $id;
	public $room;
	public $rateName;
	public $personNumber;
	public $price;
	public $comment;
	public $created;
	public $modified;
	
//	/**
//	 * Return available calendar price discounts.
//	 * 
//	 * @return calendar price discount objects
//	 * 
//	 */
//	public function getAvailableCalendarPriceDiscounts() {
//		return Room::getCalendarPriceDiscounts($this->room);
//	}
	
//	/**
//	 * Return presentable room discounts.
//	 */
//	public function getPresentableRoomDiscounts() {
//		$table = new Calendar();
//		$calendar = $table->find($this->selectCalendar)->current();
//		if (empty($calendar)) {
//			return "None";
//		} else {
//			return $calendar->name." - ".$this->selectCalendarPriceDiscount."%";
//		}	
//	}
}
?>