<?php
class HotelUser extends Zend_Db_Table_Abstract {
	
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
}
?>