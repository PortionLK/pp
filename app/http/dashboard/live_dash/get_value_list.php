<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	$filter = $_POST['filter'];
	$method = $_POST['method'];
	if($method == 'hotel_feature_types'){
		$hotelFeatureList = new HotelFeatureList();
		$hFLists = $hotelFeatureList->where('hotel_feature_type_id', '=', $filter)->get();

		$options = '';
		foreach($hFLists as $hFList){
			$options .= '<option value="' . $hFList->id . '">' . $hFList->feature . '</option>';
		}
		die($options);
	}else if($method == 'room_types'){
		/* $roomFeatureList = new RoomFeature();
		$rFLists = $roomFeatureList->where('hotel_feature_type_id', '=', $filter)->get();

		$options = '';
		foreach($hFLists as $hFList){
			$options .= '<option value="' . $hFList->id . '">' . $hFList->feature . '</option>';
		}
		die($options); */
	}
	
?>