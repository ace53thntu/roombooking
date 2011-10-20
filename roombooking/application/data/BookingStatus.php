<?php
class BookingStatus {
	/** When initialize request, status is pending */
	const PENDING = "pending";
	/** When target accept incoming booking request, status is accepted and show to sender */
	const ACCEPTED = "accepted";
	/** When target reject incoming booking request, status is rejected and show to sender */
	const REJECTED = "rejected";
	/** When sender send customer to target, it marked as delivered, show to target user */
	const DELIVERED = "delivered";
	/** When target receive customer, mark it as confirmed, show to sender  */
	const CONFIRMED = "confirmed";
	/** When sender cancel booking request, show to sender */
	const CANCELLED = "cancelled";
	const EXPIRED = "expired";
}
?>