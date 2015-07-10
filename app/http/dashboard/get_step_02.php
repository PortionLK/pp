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
	}

	if(!isset($_POST['csrf']) || $_POST['csrf'] != '83620581b63ecf30c23cd5f97cc84939'){
		$_SESSION['hotel_step_error'] = 'Some error occurred with the submission, please try again.';
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		if(!isset($_POST['hotel_feature'])){
			$_SESSION['hotel_step_error'] = 'Please select at least one feature.';
			die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-02'));
		}
		$hFeatures = $_POST['hotel_feature'];
		foreach($hFeatures as $fTId => $hFeature){
			$hType = $fTId;
			$hFIds = implode(',', $hFeature);

			$hotelFeatures = new HotelFeature();
			$toRemFeatures = $hotelFeatures->where('hotel_id', '=', $hotel_id)->get();
			$toRemFs = [];
			foreach($toRemFeatures as $toRemFeature){
				$toRemFs[] = $toRemFeature->id;
			}
			$hotelFeatures->whereIn('id', $toRemFs)->delete();
			$hotelFeatures->feature_type_id = $hType;
			$hotelFeatures->hotel_id = $hotel_id;
			$hotelFeatures->feature_ids = $hFIds;
			$hotelFeatures->save();
		}

		$_SESSION['step_02_completed'] = true;
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-03'));
	}
?>