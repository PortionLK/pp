<?php
define('_MEXEC','OK');
require_once("../../../../system/load.php");

	$reservations = new Reservations();
    $merchantReferenceNo = $_REQUEST['resid'];
    $reservations->setReservationId($merchantReferenceNo);

    $pay_data = $reservations->getReservationsFromId();
    //$pay_data = $reservations->getReservationsFromId();
    $reservations->extractor($pay_data);


    $check_in_date = str_replace("00:00:00", "", $reservations->reservationCheckInDate());
    $check_out_date = str_replace("00:00:00", "", $reservations->reservationCheckOutDate());



	$url=str_replace('http://','',HTTP_PATH). "reservation/";
	if($reservations->reservationFromBookingLink()){
		$url=str_replace('http://','',HTTP_PATH)."bookings/reservation/";
	}else{
		$url=str_replace('http://','',HTTP_PATH)."reservation/";
	}


$mycode = $url.base64_encode($merchantReferenceNo."|".date("d/m/y", strtotime($check_in_date)-1)."|".date("d/m/y", strtotime($check_out_date))) . "";
										


echo QRCodeGen::getCode($mycode);
?>