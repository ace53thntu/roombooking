<?php
class Zend_View_Helper_SearchList {
	
	protected $_view;
	function setView($view) { 
		$this->_view = $view; 
	}
	
	public function searchList($hotels, $rooms) {
		$hotelStr = "";
		$roomStr = "";
		if (count($hotels)<=0) {
			$hotelStr .= "<option label='-- Select Hotel --' value='0'>-- Select Hotel --</option>";
			$roomStr .= "<option label='-- Select Room --' value='0'>-- Select Room --</option>";
		} else {
			$hotelStr .= "<option label='-- Select Hotel --' value='0'>-- Select Hotel --</option>";
			foreach ($hotels as $hotel) {
				$hotelStr.="<option label='".$hotel->name."' value='".$hotel->id."'>".$hotel->name."</option>";
			}
			$roomStr .= "<option label='-- Select Room --' value='0'>-- Select Room --</option>";
			if (count($rooms)>0) {
				foreach ($rooms as $room) {
					$roomStr.="<option label='".$room->key."' value='".$room->id."'>".$room->key."</option>";
				}
			}
		}
		$ret["hotels"] = $hotelStr;
		$ret["rooms"] = $roomStr;
		return $ret;
	}
}
?>