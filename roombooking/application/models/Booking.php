<?php
class Booking extends Zend_Db_Table_Abstract {
	
	const FROM_HOTEL = "from_hotel";
	const TO_HOTEL = "to_hotel";
	const FROM_USER = "from_user";
	const ACTION_USER = "action_user";
	const ROOM_ID = "room_id";
	const CUSTOMER = "customer_id";
	const FROM_DATE = "from_date";
	const TO_DATE = "to_date";
	const NUMER_OF_PERSON = "number_of_person";
	const STATUS = "status";
	const RATE = "rate_id";
	const CALENDAR = "calendar_price_id";
	const DISCOUNT = "discount";
	const COMMISSION = "commission";
	const ARRIVAL_TIME = "arrival_time";
	const CREATED = "created";
	
	/**
	 * Add one booking record.
	 * 
	 * @param $data
	 */
	public function addEntry($data) {
		return $this->insert($data);
	}
}
?>