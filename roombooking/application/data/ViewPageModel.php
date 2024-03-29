<?php
class ViewPageModel extends PageModel {
	
	public $hotel;
	public $selectedRoom;
	
	/**
	 * Get hotel rooms by given hotel.
	 * 
	 * @return NULL|rooms
	 */
	public function getHotelRooms() {
		if (empty($this->hotel)) {
			return null;
		}
		return Hotel::getRooms($this->hotel);
	}
	
	/**
	 * Get booking activities
	 * 
	 * @return booking dto object array
	 */
	public function getBookingActivities() {
		$ret = array();
		$hotel = new Hotel();
		$room = new Room();
		$customer = new Customer();
		$status = array(BookingStatus::PENDING, BookingStatus::ACCEPTED, BookingStatus::REJECTED, BookingStatus::EXPIRED, BookingStatus::DELIVERED, BookingStatus::CONFIRMED);
		$bookings = Hotel::getBookingByHotelAndStatus($this->hotel, $status);
		
		foreach ($bookings as $booking) {
			$bookingDTO = new BookingDTO();
			$bookingDTO->fromHotel = $hotel->findById($booking->from_hotel);
			$bookingDTO->toHotel = $hotel->findById($booking->to_hotel);
			$bookingDTO->id = $booking->id;
			$bookingDTO->room = $room->findById($booking->room_id);
			$bookingDTO->numberOfPerson = $booking->number_of_person;
			$bookingDTO->numberOfRoom = $booking->number_of_room;
			$bookingDTO->created = $booking->created;
			$bookingDTO->fromDate = $booking->from_date;
			$bookingDTO->toDate = $booking->to_date;
			$bookingDTO->expireDate = $booking->expired_date;
			$bookingDTO->customer = $customer->findById($booking->customer_id);
			
			if ($booking->to_hotel == $this->hotel->id && $booking->status == BookingStatus::PENDING) {
				$bookingDTO->type = "New";
			} else if ($booking->from_hotel == $this->hotel->id && $booking->status == BookingStatus::PENDING) {
				$bookingDTO->type = "Pending";
			} else if ($booking->from_hotel == $this->hotel->id && $booking->status == BookingStatus::ACCEPTED) {
				$bookingDTO->type = "Accepted";
			} else if ($booking->from_hotel == $this->hotel->id && $booking->status == BookingStatus::REJECTED) {
				$bookingDTO->type = "Rejected";
			} else if ($booking->to_hotel == $this->hotel->id && $booking->status == BookingStatus::DELIVERED) {
				$bookingDTO->type = "Delivered";
			} else if ($booking->from_hotel == $this->hotel->id && $booking->status == BookingStatus::CONFIRMED) {
				$bookingDTO->type = "Confirmed";
			}
			$ret[$booking->id] = $bookingDTO;
		}
		return $ret;
	}
}
?>