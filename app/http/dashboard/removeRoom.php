<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/auth.php");

	if(isset($_SESSION['editing_hotel']) && is_numeric($_SESSION['editing_hotel'])){
		$hotel_id = $_SESSION['editing_hotel'];
	}else{
		die(header('Location: ' . $_SESSION['page_url']));
	}

	if(!isset($_POST['csrf']) || $_POST['csrf'] != '802e06de1a6b657de6e5cd8b751e39d2'){
		$_SESSION['hotel_step_error'] = 'Some error occurred with the submission, please try again.';
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		$prop = $_POST['prop'];

		$hotel = new Hotel();
		$hotel = $hotel->find($hotel_id);
		if(!$hotel){ die(header('Location: ' . DOMAIN . '404')); }

		$memberId = $hotel->member_id;
		if(!isset($_SESSION['user']['id']) || ($memberId != $_SESSION['user']['id'])){
			die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-01'));
		}

		$toRemove = new Room();
		$roomType = new RoomType();
		$roomImage = new RoomImage();

		$toRemove = $toRemove->find($prop);
		if(!$toRemove){ die(header('Location: ' . $_SESSION['page_url'])); }
		if($toRemove->hotel_id != $hotel_id){ die(header('Location: ' . $_SESSION['page_url'])); }
		$remRoomType = $roomType->find($toRemove->room_type_id);
		$remRoomType->delete();
		$remRoomImage = $roomImage->where('hotel_id', '=', $hotel_id)
			->where('room_id', '=', $toRemove->id)
			->get();
		$delImageIds = [];
		$delImages = [];
		foreach($remRoomImage as $remImage){
			$delImageIds[] = $remImage->id;
			$delImages[] = $remImage->image;
		}
		$delImageIds = array_filter($delImageIds);
		$delImages = array_filter($delImages);
		$roomImage->whereIn('id', $delImageIds)->delete();
		foreach($delImages as $delImage){
			if((strlen($delImage) > 32) && file_exists(DOC_ROOT . 'uploads/room-photos/' . $delImage)){
				unlink(DOC_ROOT . 'uploads/room-photos/' . $delImage);
			}
		}

		$_SESSION['hotel_step_error'] = 'Room removed from this submission successfully.';
		die(header('Location: ' . $_SESSION['page_url']));
	}
?>