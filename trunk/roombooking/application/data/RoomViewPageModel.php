<?php
class RoomViewPageModel extends PageModel {
	
	public $room;
	
	public function getHotel() {
		return Room::getHotel($this->room);
	}
}
?>