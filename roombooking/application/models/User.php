<?php
class User extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "user";
	
	protected $_dependentTables = array(
	   "HotelUser"
	);
	
	/**
	 * Find user by login info.
	 * 
	 * @param $username
	 * @param $password
	 * @return return user if exist
	 */
	public function findByLogin($username, $password) {
		$select = $this->select()->where("username=?", $username)
		->where("password=?", md5($password));
		return $this->fetchRow($select);
	}
}
?>