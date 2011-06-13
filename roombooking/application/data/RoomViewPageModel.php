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
	 * 
	 */
	public function getCalendarPrices() {
		
	}
}
?>