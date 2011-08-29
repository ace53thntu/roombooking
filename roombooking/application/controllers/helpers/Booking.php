<?php
class Zend_Controller_Action_Helper_Booking extends Zend_Controller_Action_Helper_Abstract {
	
	/**
	 * Convert a booking object to a booking DTO.
	 * 
	 * @param $booking
	 * @return booking DTO
	 */
	public function convertToBookingDTO($booking, $loggedInHotel) {
		$hotel = new Hotel();
		$room = new Room();
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
		if ($booking->to_hotel == $loggedInHotel->id && $booking->status == BookingStatus::PENDING) {
			$bookingDTO->type = "New";
		} else if ($booking->from_hotel == $loggedInHotel->id && $booking->status == BookingStatus::PENDING) {
			$bookingDTO->type = "Pending";
		} else if ($booking->from_hotel == $loggedInHotel->id && $booking->status == BookingStatus::ACCEPTED) {
			$bookingDTO->type = "Accepted";
		} else if ($booking->from_hotel == $loggedInHotel->id && $booking->status == BookingStatus::REJECTED) {
			$bookingDTO->type = "Rejected";
		}
		return $bookingDTO;
	}
}
?>
