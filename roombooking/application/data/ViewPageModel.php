<?php
class ViewPageModel extends PageModel {
	
	public $hotel;
	
	/**
	 * Get hotel rooms by given hotel.
	 * 
	 * @return NULL|rooms
	 */
	public function getHotelRooms() {
		if (empty($this->hotel)) {
			return null;
		}
		return Hotel::getRooms($this->hotel);
	}
}
?>