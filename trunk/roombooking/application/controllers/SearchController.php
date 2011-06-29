<?php
class SearchController extends Zend_Controller_Action {
	
	private $hotel;
	private $room;
	
	public function init() {
		$this->hotel = new Hotel();
		$this->room = new Room();
	}
	
	/**
	 * Fetch hotel info by city part.
	 */
	public function fetchhotelajaxAction() {
		$this->_helper->viewRenderer->setNoRender();   //view info disabled
		$this->_helper->getHelper('layout')->disableLayout(); //template disabled
		
		$cityPart = $this->_getParam(Hotel::CITY_PART);
		if ($cityPart == "0") {
			$hotels = $this->hotel->fetchAll();
		} else {
			$hotels = $this->hotel->findbyCityPart($cityPart);
		}
		$list = $this->view->searchList($hotels, array());
		$returnJson = $list;
		echo Zend_Json::encode($returnJson);
	}
	
	/**
	 * Fetch hotel room info by hotel id
	 */
	public function fetchroomajaxAction() {
		$this->_helper->viewRenderer->setNoRender();   //view info disabled
		$this->_helper->getHelper('layout')->disableLayout(); //template disabled
		
		$cityPart = $this->_getParam(Hotel::CITY_PART);
		$roomId = $this->_getParam("room_id");
		if ($cityPart == 0) {
			$hotels = $this->hotel->fetchAll();
		} else {
			$hotels = $this->hotel->findbyCityPart($cityPart);
		}
		$rows = Room::getRoomsByCityPart($cityPart);
		$rooms = array();
		foreach ($rows as $row) {
			$roomDTO = new RoomDTO();
			$roomDTO->id = $row->rid;
			$roomDTO->key = $row->key;
			$roomDTO->name = $row->name;
			$roomDTO->description = $row->description;
			$rooms[$row->rid] = $roomDTO;
		}
		$list = $this->view->searchList($hotels, $rooms);
		$returnJson = $list;
		echo Zend_Json::encode($returnJson);
	}
}
?>