<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/auth.php");

	if(isset($_SESSION['editing_hotel']) && is_numeric($_SESSION['editing_hotel'])){
		$hotel_id = $_SESSION['editing_hotel'];
	}else{
		die(header('Location: ' . $_SESSION['page_url']));
	}

	if(!isset($_SESSION['step_01_completed']) || $_SESSION['step_01_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-01'));
	}else if(!isset($_SESSION['step_02_completed']) || $_SESSION['step_02_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-02'));
	}

	if(!isset($_POST['csrf']) || $_POST['csrf'] != 'c7a7a96215b31d0e6d9b0c40894e2a73'){
		$_SESSION['hotel_step_error'] = 'Some error occurred with the submission, please try again.';
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		/* if((!isset($_POST['room']) || (count(array_filter($_POST['room'])) < 1)) && (isset($_SESSION['step_03_completed']) && ($_SESSION['step_03_completed'] == true))){
			die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-04'));
		}else  */
		if(!isset($_POST['room']) || (count(array_filter($_POST['room'])) < 1)){
			die(header('Location: ' . $_SESSION['page_url']));
		}
		$room = $_POST['room'];
		$rType = $room['type'];
		$rFIds = implode(',', $room['feature']);
		$rQty = $room['qty'];
		$rQtyAssigned = $room['qtyAssigned'];
		$rMaxPersons = $room['maxPersons'];
		$rMaxExtraBeds = $room['maxExtraBeds'];

		$rTypeObj = new RoomType();
		$rTypeObj->name = $rType;
		$rTypeObj->save();

		$rObj = new Room();
		$rObj->room_type_id = $rTypeObj->id;
		$rObj->room_feature_ids = $rFIds;
		$rObj->no_of_rooms = $rQty;
		$rObj->assigned_rooms = $rQtyAssigned;
		$rObj->max_persons = $rMaxPersons;
		$rObj->max_extra_beds = $rMaxExtraBeds;
		$rObj->hotel_id = $hotel_id;
		$rObj->save();

		$roomImages = $_FILES['roomImg'];
		$images = $roomImages['name'];
		$prefix = hash('md5', $hotel_id) . '_' . hash('md5', $rObj->id) . '_';
		$uploadDir = DOC_ROOT . 'uploads/room-photos/';

		foreach($images as $iK => $image){
			$nIType = $roomImages['type'][$iK];
			$nIType = explode('/', $nIType);
			$nIType1 = $nIType[0];
			$nIType2 = $nIType[1];
			if($nIType1 == 'image'){
				if($nIType2 == 'jpeg' || $nIType2 == 'pjpeg'){ $ext = '.jpg'; }
				else if($nIType2 == 'png'){ $ext = '.png'; }
				else{ $ext = '.noExt_'; }
				$nITemp = $roomImages['tmp_name'][$iK];
				$newName = $prefix . '_' . md5(time() . rand(111111111,999999999));
				$newName .= '_' . md5(time() . rand(111111111,999999999));
				$newName .= $ext;
				if(move_uploaded_file($nITemp, $uploadDir . $newName)){
					$roomImage = new RoomImage();
					$roomImage->hotel_id = $hotel_id;
					$roomImage->room_id = $rObj->id;
					$roomImage->image = $newName;
					$roomImage->save();
				}
			}
		}

		$_SESSION['step_03_completed'] = true;
		if($_POST['submit'] == 'next'){
			die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-04'));
		}else{
			die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-03'));
		}
	}
?>