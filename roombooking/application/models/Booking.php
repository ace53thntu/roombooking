<?php
class Booking extends Zend_Db_Table_Abstract {
	
	const ID = "id";
	const FROM_HOTEL = "from_hotel";
	const TO_HOTEL = "to_hotel";
	const FROM_USER = "from_user";
	const ACTION_USER = "action_user";
	const ROOM_ID = "room_id";
	const CUSTOMER = "customer_id";
	const FROM_DATE = "from_date";
	const TO_DATE = "to_date";
	const NUMBER_OF_ROOM = "number_of_room";
	const NUMBER_OF_PERSON = "number_of_person";
	const STATUS = "status";
	const PRICE = "price";
	const DISCOUNT = "discount";
	const COMMISSION = "commission";
	const ARRIVAL_TIME = "arrival_time";
	const EXPIRED_DATE = "expired_date";
	const CREATED = "created";
	
	protected $_primary = "id";
	protected $_name = "booking";
	
	protected $_referenceMap = array(
		'FromHotel' => array(
			'columns' => 'from_hotel',
			'refTableClass' => 'Hotel',
			'refColumns' => 'id'	
		),
		'ToHotel' => array(
			'columns' => 'to_hotel',
			'refTableClass' => 'Hotel',
			'refColumns' => 'id'
		),
		'FromUser' => array(
			'columns' => 'from_user',
			'refTableClass' => 'User',
			'refColumns' => 'id'
		),
		'ActionUser' => array(
			'columns' => 'action_user',
			'refTableClass' => 'User',
			'refColumns' => 'id'
		),
		'Room' => array(
			'columns' => 'room_id',
			'refTableClass' => 'Room',
			'refColumns' => 'id'
		),
		'Customer' => array(
			'columns' => 'customer_id',
			'refTableClass' => 'Customer',
			'refColumns' => 'id'
		),
	);
	
	/**
	 * Find booking by id.
	 * 
	 * @param $id
	 * @return booking
	 */
	public function findById($id) {
		return $this->find($id)->current();
	}
	
	/**
	 * Add one booking record.
	 * 
	 * @param $data
	 */
	public function addEntry($data) {
		return $this->insert($data);
	}
	
	/**
	 * Update booking
	 * 
	 * @param $data
	 * @return updated booking
	 */
	public function updateBooking($data) {
		if (!empty($data[Booking::ID])) {
			$booking = $this->findById($data[Booking::ID]);
			$booking->status = $data[Booking::STATUS];
			$booking->save();
		}
	}
	
	/**
	 * Get room of booking.
	 * 
	 * @param $booking
	 */
	public static function getRoom($booking) {
		return $booking->findParentRow("Room");
	}
}
?>