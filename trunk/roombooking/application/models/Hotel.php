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
	const CHAIN = "chain";
	const PHONE1 = "phone1";
	const PHONE2 = "phone2";
	const FAX = "fax";
	const EMAIL = "email";
	const WEBSITE = "website";
	
	const CONTACT_NAME = "contact_name";
	const CONTACT_TITLE = "contact_title";
	const CONTACT_PHONE = "contact_phone";
	const CONTACT_EMAIL = "contact_email";
	const CREATED = "created";
	const MODIFIED = "modified";
	
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
    	$table = new Room();
    	return $hotel->findDependentRowset("Room", "Hotel", $table->select()->order("name ASC"));
    }
    
    /**
     * Get hotels as displayable array, sorted by name.
     */
    public static function getHotelAsArray() {
    	$table = new Hotel();
    	$where = $table->select()->order("name ASC");
    	$rows = $table->fetchAll($where);
    	$ret = array();
    	foreach ($rows as $row) {
    		$ret[$row->id] = $row->name;
    	}
    	return $ret;
    }
    
    /**
     * Find hotel by city party, sort by name.
     * 
     * @param $cityPart
     * @param $excludeHotelIds exclude hotel ids, if any
     * @return return hotel list
     */
    public function findByCityPart($cityPart, $excludeHotelIds=null) {
    	$excludeHotelStr = "";
    	if (isset($excludeHotelIds)) {
    		foreach ($excludeHotelIds as $excludeHotelId) {
    			$excludeHotelStr .= ($excludeHotelId.",");	
    		}
    	}
    	$where = $this->select()->where("city_part=?", $cityPart);
    	if (!empty($excludeHotelStr)) {
    		$where = $where->where("id NOT IN (?)", $excludeHotelStr);
    	}
    	$where = $where->order("name ASC");
    	return $this->fetchAll($where);
    }
}
?>