<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/auth.php");

	if(!isset($_POST['csrf']) || $_POST['csrf'] != 'ee3af08b009b4b6eaab02829ce0d0497'){
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		$hotelId = intval($_POST['prop']);

		$hotel = new Hotel();
		$hotel = $hotel->find($hotelId);
		if(!$hotel){ die(header('Location: ' . DOMAIN . '404')); }

		$memberId = $hotel->member_id;
		if(isset($_SESSION['user']['id']) && ($memberId == $_SESSION['user']['id'])){
			$_SESSION['editing_hotel'] = $hotel->id;
			die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-01'));
		}else{
			die(header('Location: ' . DOMAIN . '404'));
		}
	}
?>