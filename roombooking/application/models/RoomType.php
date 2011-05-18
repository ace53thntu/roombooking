<?php
class RoomType extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "room_type";
	
	/**
	 * Return room type as array, present in the selcted box.
	 * @return return array
	 */
	public static function getRoomTypeAsArray() {
		$table = new RoomType();
		$types = $table->fetchAll($table->select());
		$arr = array();
		foreach ($types as $type) {
			$arr[$type->id] = $type->name;
		}
		return $arr;
	}
}
?>