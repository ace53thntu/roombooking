<?php
/**
 * @deprecated
 */
class CalendarPriceDiscount extends Zend_Db_Table_Abstract {
	
	const ROOM = "room_id";
	const CALENDAR = "calendar_id";
	const DISCOUNT = "discount";
	const CREATED = "created";
	const MODIFIED = "modified";
	
	protected $_primary = "id";
	protected $_name = "calendar_price_discount";
	
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
     * Add new calendar price.
     * 
     * @param $data
     * @return id
     */
    public function addCalendarPrice($data) {
    	$calendarPrice = $this->findByUnique($data[self::ROOM], $data[self::CALENDAR]);
    	if (!isset($calendarPrice)) {
    		return $this->insert($data);
    	} else {
    		return $calendarPrice->id;
    	}
    }
    
    /**
     * Find calendar price by unique constraint.
     * 
     * @param $room_id
     * @param $calendar_id
     * @return return calendar price
     */
    public function findByUnique($room_id, $calendar_id) {
    	$where = $this->select()->where("room_id=?", $room_id)->where("calendar_id=?", $calendar_id);
    	return $this->fetchRow($where);
    }
    
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