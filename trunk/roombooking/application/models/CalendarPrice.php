<?php
class CalendarPrice extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "calendar_price";
	
    protected $_referenceMap = array (
    'Room' => array (
        'columns' => 'room_id', 
        'refTableClass' => 'Room', 
        'refColumns' => 'id' 
    ),
    'Calendar' => array(
        'columns' => 'calendar_id',
        'refTableClass' => 'Calendar',
        'refColumns' => 'id'
    )
    );
    
    /**
     * Return calendar object.
     * 
     * @param $calendarPrice
     */
    public static function getCalendar($calendarPrice) {
    	return $calendarPrice->findParentRow("Calendar", "Calendar");
    }
}
?>