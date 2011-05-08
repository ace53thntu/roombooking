<?php

class Hotel extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "hotel";
	
	protected $_dependentTables = array(
       'HotelUser'
    );
}
?>