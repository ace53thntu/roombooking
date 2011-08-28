<?php
class Rate extends Zend_Db_Table_Abstract {
	
	const ID = "id";
	const ROOM = "room_id";
	const RATE = "rate_name";
	const PERSON_NUMBER = "person_number";
	const PRICE = "price";
	const CREATED = "created";
	const MODIFIED = "modified";
	
	protected $_primary = "id";
	protected $_name = "rate";
	
	protected $_referenceMap = array (
    'Room' => array (
        'columns' => 'room_id', 
        'refTableClass' => 'Room', 
        'refColumns' => 'id' 
    ),
    'RateName' => array(
        'columns' => 'rate_name',
        'refTableClass' => 'RateName',
        'refColumns' => 'id'
    )
    );
    
    /**
     * Find rate by id.
     * 
     * @param $id
     * @return return rate
     */
    public function findById($id) {
    	return $this->find($id)->current();
    }
    
    /**
     * Add new rate.
     * 
     * @param $data
     * @return return added rate id
     */
    public function addRate($data) {
    	$rate = $this->findByUnique($data[self::RATE], $data[self::ROOM], $data[self::PERSON_NUMBER]);
    	if (isset($rate)) {
    		return $rate->id;
    	} else {
    		$id = $this->insert($data);
    		return $id;
    	}
    }
    
    /**
     * Update rate by id.
     * 
     * @param $data
     * @return return rate
     */
    public function updateRate($data) {
    	$rate = $this->findById($data[self::ID]);
    	if (isset($data)) {
    		$rate->person_number = $data[self::PERSON_NUMBER];
    		$rate->price = $data[self::PRICE];
    		$rate->modified = $data[self::MODIFIED];
    		$rate->save();
    	}
    }
    
    /**
     * Delete rate by id.
     * 
     * @param $rateId
     */
    public function deleteById($rateId) {
    	$rate = $this->findById($rateId);
    	if (isset($rate)) {
    		$rate->delete();
    	}
    }
    
    /**
     * Find rate by unique constraint.
     * 
     * @param $rateName
     * @param $roomId
     * @param $personNumber
     * @return rate object
     */
    public function findByUnique($rateName, $roomId, $personNumber) {
    	$where = $this->select()->where("rate_name=?", $rateName)->where("room_id=?", $roomId)->where("person_number=?", $personNumber);
    	return $this->fetchRow($where);
    }
    
    /**
     * Find best rate for given room, best rate is the lowest price for given number of person.
     * 
     * @param $roomId
     * @param $numberOfPerson
     */
    public function findBestRate($roomId, $numberOfPerson) {
    	$where = $this->select()->where("room_id=?", $roomId)->where("person_number>=?", $numberOfPerson)->order("price ASC");
    	$rates = $this->fetchAll($where);
    	if (!empty($rates)) {
    		return $rates->current();
    	} else {
    		return null;
    	}
    }
    
    /**
     * Get rate name.
     * 
     * @param $rate
     * @return return rate name
     */
    public static function getRateName($rate) {
    	return $rate->findParentRow("RateName", "RateName");
    }
}
?>