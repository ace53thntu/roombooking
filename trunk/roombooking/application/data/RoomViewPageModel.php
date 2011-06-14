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
	
	/**
	 * Return calendar prices of given room, if any.
	 * 
	 * return calendar prices
	 */
	public function getCalendarPrices() {
		$ret = array();
		foreach (Room::getCalendarPrices($this->room) as $calendarPrice) {
			$calendarPriceDTO = new CalendarPriceDTO();
			$calendarPriceDTO->calendar = CalendarPrice::getCalendar($calendarPrice);
			$calendarPriceDTO->price = $calendarPrice->price;
			$calendarPriceDTO->created = $calendarPrice->created;
			$calendarPriceDTO->modified = $calendarPrice->modified;
			$ret[$calendarPrice->id] = $calendarPriceDTO;
		}
		return $ret;
	}
}
?>