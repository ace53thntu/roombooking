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
	 * 
	 * @param $roomId
	 * @param $discount
	 */
	public function addOrUpdateDiscount($roomId, $discount) {
		$data = array(
		"room_id" => $roomId,
		"price" => $discount
		);
		return $this->insert($data);
	}
}
?>