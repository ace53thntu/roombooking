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
       'Discount',
	   'Commission',
	   'CalendarPrice',
	   'Rate',
	   'Booking'
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
     * Find all rooms by city part, order by key.
     * 
     * @param $cityPart
     * @return return rooms
     */
    public static function getRoomsByCityPart($cityPart, $excludeHotelIds) {
    	$excludeHotelStr = "";
    	foreach ($excludeHotelIds as $excludeHotelId) {
    		$excludeHotelStr .= ($excludeHotelId.",");
    	}
    	$table = new Room();
    	$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
        ->setIntegrityCheck(false)
        ->from(array("r"=>"room"), array("rid"=>"r.id", "key"=>"r.key", "name"=>"r.name", "description"=>"r.description"))
        ->join(array("h"=>"hotel"), "r.hotel_id=h.id")
        ->where("h.city_part=?", $cityPart);
        if (!empty($excludeHotelStr)) {
        	$select = $select->where("h.id NOT IN (?)", $excludeHotelStr);
        }
        $select = $select->group("r.id")
        ->order("r.key");
        return $table->fetchAll($select);
    }
    
    /**
     * Find room by criteria.
     *  
     * @param $cityPart
     * @param $hotelId
     * @param $roomId
     * @param $excludeHotel exclude hotel object
     * @return return rooms
     */
    public static function getRoomsBySearchCriteria($cityPart, $hotelId, $roomId, $excludeHotel=null) {
    	$ret = array();
    	$table = new Room();
    	if (!empty($roomId) && $roomId != 0) {
    		$ret[0] = $table->findById($roomId);
    	} else if (!empty($hotelId) && $hotelId != 0) {
    		$table = new Hotel();
    		$hotel = $table->findById($hotelId);
    		$ret = Hotel::getRooms($hotel);
    	} else {
    		$excludeHotelsStr = "";
    		if (isset($excludeHotel)) {
    			$excludeHotelsStr = array(
    				$excludeHotel->id => $excludeHotel->id
    			);
    		}
    		$rooms = Room::getRoomsByCityPart($cityPart, $excludeHotelsStr);
    		foreach ($rooms as $room) {
    			$ret[$room->rid] = $room;
    		}
    	}
    	return $ret;
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
     * Get room's commission.
     * @param $room
     */
    public static function getCommission($room) {
    	$commissions = $room->findDependentRowset("Commission", "Room");
    	if (count($commissions) > 0) {
    		return $commissions->current()->commission;
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
    
    /**
     * Return calendar price of given room.
     * 
     * @param $room
     * @return return calendar prices
     */
    public static function getCalendarPrices($room) {
    	return $room->findDependentRowset("CalendarPrice", "Room");
    }
    
    /**
     * Find room rates.
     * 
     * @param $room
     * @return rates of room
     */
    public static function getRoomRates($room) {
        return $room->findDependentRowset("Rate", "Room");
    }
    
    /**
     * Return room rate, it's one-to-one now.
     * 
     * @param $room
     * @return return room rate
     */
    public static function getRoomRate($room) {
    	if (isset($room)) {
	    	$rates = $room->findDependentRowset("Rate", "Room");
	    	return count($rates) > 0 ? $rates->current() : null;
    	} else {
    		return null;
    	}
    }
}
?>