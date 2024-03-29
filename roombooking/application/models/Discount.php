<?php
class Discount extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "discount";
	
	protected $_referenceMap = array (
    'Room' => array (
        'columns' => 'room_id', 
        'refTableClass' => 'Room', 
        'refColumns' => 'id' 
    )
    );
	
    /**
     * Find discount by roomId.
     * 
     * @param $roomId
     */
    public function findByRoom($roomId) {
    	$select = $this->select()->where("room_id=?", $roomId);
    	return $this->fetchRow($select);
    }
    
	/**
	 * 
	 * @param $roomId
	 * @param $discount
	 */
	public function addOrUpdateDiscount($roomId, $discount, $created, $modified) {
		$data = array(
		"room_id" => $roomId,
		"discount" => $discount,
		"created" => $created,
		"modified" => $modified
		);
		$obj = $this->findByRoom($roomId);
		if (empty($obj)) {
			return $this->insert($data);
		} else {
			$obj->discount = $discount;
			$obj->modified = $modified;
			$obj->save();
		}
	}
}
?>