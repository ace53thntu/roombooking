<?php
class Room extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "room";
	
	protected $_referenceMap = array (
    'Hotel' => array (
        'columns' => 'hotel_id', 
        'refTableClass' => 'Hotel', 
        'refColumns' => 'id' 
    )
    );
}
?>