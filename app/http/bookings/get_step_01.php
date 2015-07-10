<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/auth.php");

	if(!isset($_POST['csrf']) || $_POST['csrf'] != '4950ab6a5b3ef7addeb8d7fb2b2789e8'){
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		$checkIn = $_POST['check_in'];
		$checkOut = $_POST['check_out'];
		if(isset($_POST['hotel']) && is_numeric($_POST['hotel'])){
			$hotelId = intval($_POST['hotel']);
			$_SESSION['booking_hotel_id'] = $hotelId;
		}else{
			$_SESSION['booking_nav_error'] = 'Looks like you want to start again.';
			die(header('Location: ' . $_SESSION['page_url']));
		}

		$hotel = new Hotel();
		$room = new Room();
		$bookedDate = new BookedDate();
		$availability = new Availability();

		$avRooms = $room->where('rooms.hotel_id', '=', $hotelId)
			->join('availabilities', 'rooms.id', '=', 'availabilities.room_id')
			->whereRaw('availabilities.no_of_rooms > availabilities.booked_rooms')
			->join('booked_dates', 'availabilities.room_id', '=', 'booked_dates.room_id')
			->whereRaw('booked_dates.no_of_rooms > availabilities.booked_rooms')
			->get();
		if(count($avRooms)){
			$_SESSION['booking_step_01_completed'] = true;
			die(header('Location: ' . DOMAIN . "bookings/{$hotel->seo_url}/step-02"));
		}else{
			$_SESSION['booking_nav_error'] = 'No rooms available for the mentioned period.';
			die(header('Location: ' . $_SESSION['page_url']));
		}
	}
?>