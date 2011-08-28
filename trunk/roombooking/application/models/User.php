<?php
class User extends Zend_Db_Table_Abstract {
	
	protected $_primary = "id";
	protected $_name = "user";
	
	protected $_dependentTables = array(
	   "HotelUser",
	   "Booking"
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
	
	/**
	 * Find user by id.
	 * 
	 * @param $id
	 * @return return user
	 */
	public function findById($id) {
		return $this->find($id)->current();
	}
	
	/**
	 * Find hotels which given user is the administrator.
	 * 
	 * @param $user
	 * @return hotel|NULL
	 */
	public static function getHotel($user) {
		$hotelUser = new HotelUser();
		$user->setTable(new User());
		$hotels = $user->findManyToManyRowset("Hotel", "HotelUser", "User", 'Hotel', $hotelUser->select()->where("permission_id=?", UserPermission::ADMIN));
		if (isset($hotels) && count($hotels) > 0) {
			return $hotels[0];
		} else {
			return null;
		}
	}
}
?>