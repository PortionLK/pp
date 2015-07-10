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
	}

	if(!isset($_POST['csrf']) || $_POST['csrf'] != '05243c527493c2145a9023d2fac0dc59'){
		$_SESSION['hotel_step_error'] = 'Some error occurred with the submission, please try again.';
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		/* if((!isset($_POST['rate']) || (count(array_filter($_POST['rate'])) < 5)) && (isset($_SESSION['step_05_completed']) && ($_SESSION['step_05_completed'] == true))){
			die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-06'));
		}else  */
		if(!isset($_POST['rate']) || (count(array_filter($_POST['rate'])) < 5)){
			$_SESSION['hotel_step_error'] = 'All fields are required with at least one row from rate table.';
			die(header('Location: ' . $_SESSION['page_url']));
		}
		$rates = $_POST['rate'];

		//print_r($rates['tableLocal']);die();
		/**
		 *	In $rates['table'], first key represents room_bed_type_id
		 *	and second key represents service_type_id.
		 *	Each service type has 4 kinds of rates, that is fit rate, net rate, agent rate and
		 *	sell rate represents by fr, nr, ar and sr keys respectively.
		 */
		foreach($rates['table'] as $bedTypeId => $bedType){
			foreach($bedType as $serviceTypeId => $serviceType){
				$roomRate = new RoomRate();
				//main attributes
				$roomRate->hotel_id = $hotel_id;
				$roomRate->room_type_id = $rates['type'];
				$roomRate->currency_id = 2;
				$roomRate->season = $rates['season'];
				$roomRate->start = $rates['from'];
				$roomRate->end = $rates['to'];
				//sub attributes
				$roomRate->service_type_id = $serviceTypeId;
				$roomRate->room_bed_type_id = $bedTypeId;
				//rates
				$roomRate->fit_rate = $serviceType['fr'];
				$roomRate->net_rate = $serviceType['nr'];
				$roomRate->agent_rate = $serviceType['ar'];
				$roomRate->sell_rate = $serviceType['sr'];
				//additional info
				$roomRate->foreign_discount_rate = $rates['foreignDiscountRate'];
				$roomRate->foreign_min_price = $rates['foreignMinPrice'];
				$roomRate->local_discount_rate = $rates['localDiscountRate'];
				$roomRate->local_min_price = $rates['localMinPrice'];

				$roomRate->save();
			}
		}

		foreach($rates['tableLocal'] as $bedTypeIdLocal => $bedTypeLocal){
			foreach($bedTypeLocal as $serviceTypeIdLocal => $serviceTypeLocal){
				$roomRate = new RoomRate();
				//main attributes
				$roomRate->hotel_id = $hotel_id;
				$roomRate->room_type_id = $rates['type'];
				$roomRate->currency_id = 1;
				$roomRate->season = $rates['season'];
				$roomRate->start = $rates['from'];
				$roomRate->end = $rates['to'];
				//sub attributes
				$roomRate->service_type_id = $serviceTypeIdLocal;
				$roomRate->room_bed_type_id = $bedTypeIdLocal;
				//rates
				$roomRate->fit_rate = $serviceTypeLocal['fr'];
				$roomRate->net_rate = $serviceTypeLocal['nr'];
				$roomRate->agent_rate = $serviceTypeLocal['ar'];
				$roomRate->sell_rate = $serviceTypeLocal['sr'];
				//additional info
				$roomRate->foreign_discount_rate = $rates['foreignDiscountRate'];
				$roomRate->foreign_min_price = $rates['foreignMinPrice'];
				$roomRate->local_discount_rate = $rates['localDiscountRate'];
				$roomRate->local_min_price = $rates['localMinPrice'];

				$roomRate->save();
			}
		}

		$_SESSION['step_05_completed'] = true;
		if($_POST['submit'] == 'next'){
			die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-06'));
		}else{
			die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-05'));
		}
	}
?>