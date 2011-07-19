<?php
class HotelUser extends Zend_Db_Table_Abstract {
	
	const HOTEL = "hotel_id";
	const USER = "user_id";
	const PERMISSION = "permission_id";
	
	protected $_primary = "id";
	protected $_name = "hotel_user";
	
	protected $_referenceMap = array (
    'Hotel' => array (
        'columns' => 'hotel_id', 
        'refTableClass' => 'Hotel', 
        'refColumns' => 'id' 
    ),
    'User' => array (
        'columns' => 'user_id', 
        'refTableClass' => 'User', 
        'refColumns' => 'id' 
    )
    );
    
    /**
     * Add hotel user.
     * 
     * @param $data
     */
    public function addHotelUser($data) {
    	$hotelUser = $this->findByUnique($data[self::HOTEL], $data[self::USER], $data[self::PERMISSION]);
    	if (!isset($hotelUser)) {
    		$this->insert($data);
    	}
    }
    
    /**
     * Find hotel user by unique constraint.
     * 
     * @param $hotelId
     * @param $userId
     * @param $permission
     * @return return hotel user
     */
    public function findByUnique($hotelId, $userId, $permission) {
    	$select = $this->select()->where("hotel_id=?", $hotelId)
    	->where("user_id=?",$userId)
    	->where("permission_id=?", $permission);
    	return $this->fetchRow($select);
    }
}
?>