<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(isset($_SESSION['editing_hotel']) && is_numeric($_SESSION['editing_hotel'])){
		$hotel_id = $_SESSION['editing_hotel'];
	}else{
		die(header('Location: ' . $_SESSION['page_url']));
	}

	if(!isset($_SESSION['step_01_completed']) || $_SESSION['step_01_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-01'));
	}else if(!isset($_SESSION['step_02_completed']) || $_SESSION['step_02_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-02'));
	}else if(!isset($_SESSION['step_03_completed']) || $_SESSION['step_03_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-03'));
	}

	if(!isset($_POST['csrf']) || $_POST['csrf'] != 'd1b30e3e603d149cd12327fe2ec7510d'){
		$_SESSION['hotel_step_error'] = 'Some error occurred with the submission, please try again.';
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		if(!isset($_POST['info']) || (count(array_filter($_POST['info'])) < 1)){
			die(header('Location: ' . $_SESSION['page_url']));
		}
		$info = $_POST['info'];

		$hotelAttribute = new HotelAttribute();
		$hotelAttribute->hotel_id = $hotel_id;
		$hotelAttribute->is_airport_transfer = $info['is_transport'];
		$hotelAttribute->airport_transfer_fee = $info['ransport_fee'];
		$hotelAttribute->distance_to_airport = $info['distance'];
		$hotelAttribute->check_in = $info['check_in'];
		$hotelAttribute->check_out = $info['check_out'];
		$hotelAttribute->save();

		$_SESSION['step_04_completed'] = true;
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-05'));
	}
?>