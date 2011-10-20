<?php
class RoomViewPageModel extends PageModel {
	
	public $room;

	/**
	 * Get hotel of the given room
	 * @return return return hotel
	 */
	public function getHotel() {
		return Room::getHotel($this->room);
	}
	
//	/**
//	 * Return calendar prices of given room, if any.
//	 * 
//	 * return calendar prices
//	 */
//	public function getCalendarPrices() {
//		$ret = array();
//		foreach (Room::getCalendarPriceDiscounts($this->room) as $calendarPrice) {
//			$calendarPriceDTO = new CalendarPriceDTO();
//			$calendarPriceDTO->calendar = CalendarPrice::getCalendar($calendarPrice);
//			$calendarPriceDTO->price = $calendarPrice->price;
//			$calendarPriceDTO->created = $calendarPrice->created;
//			$calendarPriceDTO->modified = $calendarPrice->modified;
//			$ret[$calendarPrice->id] = $calendarPriceDTO;
//		}
//		return $ret;
//	}
	
	/**
	 * Return room rates.
	 * 
	 * @return return room rates DTO
	 */
	public function getRoomRates() {
		$ret = array();
		foreach(Room::getRoomRates($this->room) as $rate) {
			$rateDTO = new RateDTO();
			$rateDTO->id = $rate->id;
			$rateDTO->rateName = Rate::getRateName($rate)->name;
			$rateDTO->personNumber = $rate->person_number;
			$rateDTO->price = $rate->price;
			$rateDTO->comment = $rate->comment;
			$rateDTO->created = $rate->created;
			$rateDTO->modified = $rate->modified;
			$ret[$rate->id] = $rateDTO;
		}
		return $ret;
	}
	
	/**
	 * Get room discount info.
	 */
	public function getRoomDiscounts() {
		$ret = array();
		foreach (Room::getRoomDiscounts($this->room) as $roomDiscount) {
			$roomDiscountDTO = new RoomDiscountDTO();
			$roomDiscountDTO->id = $roomDiscount->id;
			$roomDiscountDTO->roomDiscountRule = RoomDiscount::getRule($roomDiscount);
			$roomDiscountDTO->discount = $roomDiscount->discount;
			$ret[$roomDiscount->id] = $roomDiscountDTO;
		}
		return $ret;
	}
}
?>