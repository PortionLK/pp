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
	}else if(!isset($_SESSION['step_04_completed']) || $_SESSION['step_04_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-04'));
	}else if(!isset($_SESSION['step_05_completed']) || $_SESSION['step_05_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-05'));
	}

	if(!isset($_POST['csrf']) || $_POST['csrf'] != 'ec14f83d70784a0c311a09533c9f9a23'){
		$_SESSION['hotel_step_error'] = 'Some error occurred with the submission, please try again.';
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		if((!isset($_POST['assign']) || (count(array_filter($_POST['assign'])) < 1)) && (isset($_SESSION['step_06_completed']) && ($_SESSION['step_06_completed'] == true))){
			die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-06'));
		}else if(!isset($_POST['assign']) || (count(array_filter($_POST['assign'])) < 1)){
			$_SESSION['hotel_step_error'] = 'All fields are required with at least one row from rate table.';
			die(header('Location: ' . $_SESSION['page_url']));
		}
		$assign = $_POST['assign'];

		foreach($assign['roomType'] as $slotKey => $slot){
			$assignedRoom = new AssignedRoom();
			$existRoom = $assignedRoom->where('hotel_id', '=', $hotel_id)
				->where('room_type_id', '=', $slotKey, 'AND')
				->first();
			if(count($existRoom) == 0){
				$assignedRoom->hotel_id = $hotel_id;
				$assignedRoom->room_type_id = $slotKey;
				$assignedRoom->start_date = $assign['start'][$slotKey];
				$assignedRoom->end_date = $assign['end'][$slotKey];
				$assignedRoom->num_of_rooms = $assign['roomQty'][$slotKey];
				$assignedRoom->save();
			}else{
				$existRoom->hotel_id = $hotel_id;
				$existRoom->room_type_id = $slotKey;
				$existRoom->start_date = $assign['start'][$slotKey];
				$existRoom->end_date = $assign['end'][$slotKey];
				$existRoom->num_of_rooms = $assign['roomQty'][$slotKey];
				$existRoom->save();
			}
		}

		//$_SESSION['step_06_completed'] = true; //uncomment for continuity

		$_SESSION['step_01_completed'] = false;
		$_SESSION['step_02_completed'] = false;
		$_SESSION['step_03_completed'] = false;
		$_SESSION['step_04_completed'] = false;
		$_SESSION['step_05_completed'] = false;
		$_SESSION['step_06_completed'] = false;

		unset($_SESSION['step_01_completed']);
		unset($_SESSION['step_02_completed']);
		unset($_SESSION['step_03_completed']);
		unset($_SESSION['step_04_completed']);
		unset($_SESSION['step_05_completed']);
		unset($_SESSION['step_06_completed']);

		die(header('Location: ' . DOMAIN . 'dashboard/list-hotels'));
	}
?>