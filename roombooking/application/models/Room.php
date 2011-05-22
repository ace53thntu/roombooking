<?php
class Room extends Zend_Db_Table_Abstract {
	
	const ID = "id";
	const HOTEL = "hotel_id";
	const TYPE = "type_id";
	const TOTAL = "total";
	const MAX_PERSON = "max_person";
	const DESCRIPTION = "description";
	const AVAILABLE = "available";
	
	protected $_primary = "id";
	protected $_name = "room";
	
	protected $_dependentTables = array(
       'Discount'
    );
	
	protected $_referenceMap = array (
    'Hotel' => array (
        'columns' => 'hotel_id', 
        'refTableClass' => 'Hotel', 
        'refColumns' => 'id' 
    )
    );
    
    /**
     * Add new room, if room already exist, return it.
     * 
     * @param $data
     * @return room object
     */
    public function addRoom($data) {
    	$room = $this->findByUnique($data[self::HOTEL], $data[self::TYPE]);
    	if (empty($room)) {
    		$id = $this->insert($data);
    		$room = $this->findById($id);
    	}
    	return $room;
    }
    
    /**
     * Update room info.
     * 
     * @param $data
     * @return room
     */
    public function updateRoom($data) {
    	$room = $this->findById($data[self::ID]);
    	if (!empty($room)) {
    		if (!empty($data[self::AVAILABLE])) {
    			$room->available = $data[self::AVAILABLE];
    			$room->save(); 
    			return $room;
    		} else {
    			return $room;
    		}
    	}
    	return null;
    }
    
    /**
     * Find room by id.
     * 
     * @param $id
     * @return return room object
     */
    public function findById($id) {
    	return $this->find($id)->current();
    }
    
    /**
     * Find room by unique constraint.
     * 
     * @param $hotel_id
     * @param $type_id
     * @return return room
     */
    public function findByUnique($hotel_id, $type_id) {
    	$select = $this->select()->where("hotel_id=?", $hotel_id)
    	->where("type_id=?", $type_id);
    	return $this->fetchRow($select);
    }
    
    /**
     * Get room's discount.
     * @param $room
     */
    public static function getDiscount($room) {
    	return $room->findDependentRowset("Discount", "Room")->current();
    }
}
?>