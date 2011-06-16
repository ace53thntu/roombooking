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