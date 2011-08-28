<?php
class Customer extends Zend_Db_Table_Abstract {
	
	const FIRST_NAME = "first_name";
	const LAST_NAME = "last_name";
	const SOCIAL_SECURITY_NUMBER = "social_security_number";
	const PHONE = "phone";
	
	protected $_primary = "id";
	protected $_name = "customer";
	
	protected $_dependentTables = array('Booking');
	
	/**
	 * Find customer by unique constraint.
	 * 
	 * @param $socialSecurityNumber
	 * @return return customer object
	 */
	public function findByUnique($socialSecurityNumber) {
		$select = $this->select()->where("social_security_number=?", $socialSecurityNumber);
		return $this->fetchRow($select);
	}
	
	/**
	 * Add customer.
	 * 
	 * @param $data
	 * @return return id
	 */
	public function addCustomer($data) {
		$customer = $this->findByUnique($data[self::SOCIAL_SECURITY_NUMBER]);
		if (isset($customer)) {
			return $customer->id;
		} else {
			return $this->insert($data);
		}
	}
}
?>