<?php
class Room extends Zend_Db_Table_Abstract {
	
	const ID = "id";
	const HOTEL = "hotel_id";
	const NAME = "name";
	const KEY = "key";
	const TOTAL = "total";
	const MAX_ADULTS = "max_adults";
	const MAX_CHILDREN = "max_children";
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
    	$room = $this->findByUnique($data[self::HOTEL], $data[self::KEY]);
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
     * @param $key
     * @return return room
     */
    public function findByUnique($hotel_id, $key) {
    	$select = $this->select()->where("hotel_id=?", $hotel_id)
    	->where("`key`=?", $key);
    	return $this->fetchRow($select);
    }
    
    /**
     * Get room's discount.
     * @param $room
     */
    public static function getDiscount($room) {
    	$discounts = $room->findDependentRowset("Discount", "Room");
    	if (count($discounts) > 0) {
    		return $discounts->current()->discount;
    	} else {
    		return 0;
    	}
    }
    
    /**
     * Get hotel of the room.
     * 
     * @param $room
     * @return return hotel
     */
    public static function getHotel($room) {
    	return $room->findParentRow ( "Hotel", "Hotel" );
    }
}
?>