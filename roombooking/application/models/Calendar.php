<?php
class Calendar extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "calendar";
	
	protected $_dependentTables = array(
       "Rate"
    );
	
	/**
	 * Get calendar as array, used in select box.
	 * 
	 * @return calendar array
	 */
	public static function getCalendarAsArray() {
		$table = new Calendar();
		$ret = array();
		foreach($table->fetchAll() as $calendar) {
			$ret[$calendar->id] = $calendar->name;
		}
		return $ret;
	}
}
?>