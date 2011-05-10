<?php

class Hotel extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "hotel";
	
	protected $_dependentTables = array(
       'HotelUser',
	   'Room'
    );
    
    /**
     * Get rooms in given hotels.
     * 
     * @param $hotel
     * @return rooms in given hotel
     */
    public static function getRooms($hotel) {
    	return $hotel->findDependentRowset("Room", "Hotel");
    }
}
?>