<?php
class Permission extends Zend_Db_Table_Abstract {
	
	const ADMIN = 1;
	
	protected $_primary = "id";
	protected $_name = "permission";
}
?>