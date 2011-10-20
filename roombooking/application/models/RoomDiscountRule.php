<?php
class RoomDiscountRule extends Zend_Db_Table_Abstract {
	const UNKNOWN = 1;
	const SUMMER_TIME = 2;
	const CHILD_DISCOUNT = 3;
	
	protected $_primary = "id";
	protected $_name = "room_discount_rule";
	
	protected $_dependentTables = array(
       "RoomDiscount"
    );
    
    /**
     * Return room discount rules as presentable array.
     */
    public static function getRoomDiscountRuleAsArray() {
    	$table = new RoomDiscountRule();
    	$ret = array();
    	foreach ($table->fetchAll() as $roomDiscountRule) {
    		$ret[$roomDiscountRule->id] = $roomDiscountRule->key." - ".$roomDiscountRule->rule_name;
    	}
    	return $ret;
    }
}
?>