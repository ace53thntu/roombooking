<?php
class RoomDTO {
	
	public $id;
	public $key;
	public $name;
	public $description;
	
	/**
	 * Return calendar prices of given room, if any.
	 * 
	 * return calendar prices
	 */
	public function getCalendarPrices() {
		$ret = array();
		$table = new Room();
		$room = $table->findById($this->id);
		foreach (Room::getCalendarPrices($room) as $calendarPrice) {
			$calendarPriceDTO = new CalendarPriceDTO();
			$calendarPriceDTO->calendar = CalendarPrice::getCalendar($calendarPrice);
			$calendarPriceDTO->price = $calendarPrice->price;
			$calendarPriceDTO->created = $calendarPrice->created;
			$calendarPriceDTO->modified = $calendarPrice->modified;
			$ret[$calendarPrice->id] = $calendarPriceDTO;
		}
		return $ret;
	}
	
	/**
	 * Return room rates.
	 * 
	 * @return return room rates
	 */
	public function getRoomRates() {
		$ret = array();
		$table = new Room();
		$room = $table->findById($this->id);
		foreach(Room::getRoomRates($room) as $rate) {
			$rateDTO = new RateDTO();
			$rateDTO->id = $rate->id;
			$rateDTO->rateName = Rate::getRateName($rate)->name;
			$rateDTO->personNumber = $rate->person_number;
			$rateDTO->price = $rate->price;
			$rateDTO->created = $rate->created;
			$rateDTO->modified = $rate->modified;
			$ret[$rate->id] = $rateDTO;
		}
		return $ret;
	}
}
?>