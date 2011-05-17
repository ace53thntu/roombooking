<?php

class Hotel extends Zend_Db_Table_Abstract {
	
	const NAME = "name";
	const DESCRIPTION = "description";
	const RATING = "rating";
	const ADDRESS = "address";
	const POST_ADDRESS = "post_address";
	const POST_CODE = "post_code";
	const CITY = "city";
	const CITY_PART = "city_part";
	
	protected $_primary = "id";
	protected $_name = "hotel";
	
	protected $_dependentTables = array(
       'HotelUser',
	   'Room'
    );
    
    protected $_referenceMap = array(
        'City' => array (
	        'columns' => 'city', 
	        'refTableClass' => 'City', 
	        'refColumns' => 'id' 
        )
    );
    
    /**
     * Find hotel by given id.
     * 
     * @param $id
     * @return return hotel object
     */
    public function findById($id) {
    	return $this->find($id)->current();
    }
    
    /**
     * Add one hotel, if new.
     * 
     * @param $data
     * @return hotel object
     */
    public function addHotel($data) {
    	$hotel = $this->findByUnique($data[self::NAME], $data[self::CITY]);
    	if (empty($hotel)) {
    		$id = $this->insert($data);
    		return $this->findById($id);
    	} else {
    		return $hotel;
    	}
    }
    
    /**
     * Find hotel by unique constraint.
     * 
     * @param $name
     * @param $city
     * @return return hotel object
     */
    public function findByUnique($name, $city) {
    	$select = $this->select()->where("name=?", $name)
    	->where("city=?", $city);
    	return $this->fetchRow($select);
    }
    
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