<?php
class RoomDiscount extends Zend_Db_Table_Abstract {
	const ID = "id";
	const ROOM = "room_id";
	const RULE = "rule_id";
	const DISCOUNT = "discount";
	const CREATED = "created";
	const MODIFIED = "modified";
	
	protected $_primary = "id";
	protected $_name = "room_discount";
	
	protected $_referenceMap = array (
	'Room' => array (
        'columns' => 'room_id', 
        'refTableClass' => 'Room', 
        'refColumns' => 'id' 
    ),
    'Rule' => array (
        'columns' => 'rule_id', 
        'refTableClass' => 'RoomDiscountRule', 
        'refColumns' => 'id' 
    )
    );
    
    /**
     * Add new room discount.
     * 
     * @param $data
     */
    public function addNew($data) {
    	$roomDiscount = $this->findByUnique($data[self::ROOM], $data[self::RULE]);
    	if (empty($roomDiscount)) {
    		return $this->insert($data);
    	} else {
    		return $roomDiscount->id;
    	}
    }
    
    /**
     * Delete room discount by id.
     * 
     * @param $id
     */
    public function deleteById($id) {
    	$obj = $this->find($id)->current();
    	if (!empty($obj)) {
    		$obj->delete();
    	}
    }
    
    /**
     * Delete room discount by unique constraint.
     * 
     * @param $roomId
     * @param $ruleId
     */
    public function deleteByRoomAndRule($roomId, $ruleId) {
    	$roomDiscount = $this->findByUnique($roomId, $ruleId);
    	if (!empty($roomDiscount)) {
    		$roomDiscount->delete();
    	}
    }
    
    /**
     * Find by unique constraint.
     * 
     * @param $roomId
     * @param $ruleId
     */
    public function findByUnique($roomId, $ruleId) {
    	$where = $this->select()->where("room_id=?",$roomId)
    	->where("rule_id=?", $ruleId);
    	return $this->fetchRow($where);
    }
    
    /**
     * Update room discount.
     * 
     * @param $data
     */
    public function updateRoomDiscount($data) {
    	if (!empty($data[self::ID])) {
    		$obj = $this->find($data[self::ID])->current();
    		$obj->discount = $data[self::DISCOUNT];
    		$obj->save();
    	}
    }
    
    /**
     * Get room discount rule.
     * 
     * @param $roomDiscount
     */
    public static function getRule($roomDiscount) {
    	return $roomDiscount->findParentRow("RoomDiscountRule", "Rule");
    }
    
	/**
     * Get room.
     * 
     * @param $roomDiscount
     */
    public static function getRoom($roomDiscount) {
    	return $roomDiscount->findParentRow("Room", "Room");
    }
}
?>