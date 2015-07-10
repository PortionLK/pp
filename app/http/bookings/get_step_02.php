<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/auth.php");

	if(!isset($_POST['csrf']) || $_POST['csrf'] != '179826a2de81ec53c09f7f6e3a2b18ff'){
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		$post = $_POST;
		if(isset($_POST['hotel']) && is_numeric($_POST['hotel'])){
			$hotelId = intval($_POST['hotel']);
			$_SESSION['booking_hotel_id'] = $hotelId;
		}else{
			$_SESSION['booking_nav_error'] = 'Looks like you want to start again.';
			die(header('Location: ' . $_SESSION['page_url']));
		}

	}

	if(!isset($_SESSION['booking_step_01_completed']) && $_SESSION['booking_step_01_completed'] != true){
		die(header('Location: ' . DOMAIN . "bookings/$hotel->seo_url/step-02"));
	}

	if(!isset($_POST['csrf']) || $_POST['csrf'] != '4d29198183ee43770967919813d915f0'){
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		$checkIn = $_POST['check_in'];
		$checkOut = $_POST['check_out'];
		if(isset($_POST['hotel']) && is_numeric($_POST['hotel'])){
			$hotelId = intval($_POST['hotel']);
		}else{
			$_SESSION['booking_nav_error'] = 'Looks like you want to start again.';
			die(header('Location: ' . $_SESSION['page_url']));
		}

		$hotel = new Hotel();
		$bookedDate = new BookedDate();
		$availability = new Availability();

		$hotel = $hotel->find($hotelId);
		$avRooms = $availability->where('hotel_id', '=', $hotelId)
			->whereRaw('no_of_rooms > booked_rooms')
			->get(['room_id']);

		$_SESSION['booking_step_01_completed'] = true;
		die(header('Location: ' . DOMAIN . "bookings/$hotel->seo_url/step-02"));
	}
?>