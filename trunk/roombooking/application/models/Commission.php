<?php
class Commission extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "commission";
	
	protected $_referenceMap = array (
    'Room' => array (
        'columns' => 'room_id', 
        'refTableClass' => 'Room', 
        'refColumns' => 'id' 
    )
    );
	
	/**
     * Find commission by roomId.
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
	 * @param $commission
	 */
	public function addOrUpdateCommission($roomId, $commission, $created, $modified) {
		$data = array(
		"room_id" => $roomId,
		"commission" => $commission,
		"created" => $created,
		"modified" => $modified
		);
		$obj = $this->findByRoom($roomId);
		if (empty($obj)) {
			return $this->insert($data);
		} else {
			$obj->commission = $commission;
			$obj->modified = $modified;
			$obj->save();
		}
	}
}
?>