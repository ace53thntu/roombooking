<?php
class RateName extends Zend_Db_Table_Abstract {
	
	protected $_name = "rate_name";
	protected $_primary = "id";
	
	protected $_dependentTables = array(
       "Rate"
    );
    
    /**
     * @return return rate name as array.
     */
    public static function getRateNameAsArray() {
    	$table = new RateName();
    	$ret = array();
    	foreach ($table->fetchAll() as $rateName) {
    		$ret[$rateName->id] = $rateName->key;
    	}
    	return $ret;
    }
}
?>