<?php

define('_MEXEC', 'OK');
require_once("system/load.php");
//include("pgconfig.php");
$trans_msg = "";

$hotels = new Hotels();

$client;
$client_title = "";
$client_name = "";
$client_mobile = "";
$client_email = "";
$client_message = "";
$client_city = "";
$client_country = "";
$client_address = "";
//paycorp-ipg-response.php?status=50020&merchant_reference_no=290

$transactionTypeCode = $_REQUEST["transaction_type_code"];
$installments = $_REQUEST["installments"];
$transactionId = $_REQUEST["transaction_id"];

//$amount = $_REQUEST["amount"];
$exponent = $_REQUEST["exponent"];
$currencyCode = $_REQUEST["currency_code"];
//$merchantReferenceNo = $_REQUEST["merchant_reference_no"];

$eci = $_REQUEST["3ds_eci"];
$pgErrorCode = $_REQUEST["pg_error_code"];

$pgErrorDetail = $_REQUEST["pg_error_detail"];
$pgErrorMsg = $_REQUEST["pg_error_msg"];
$messageHash = $_REQUEST["message_hash"];
//http://roomista.com/paycorp-ipg-response.php?responseCode=00&metaData2=292&metaData1=e4b6da10bbecc1722721a7942d18c592
//--
$status = $_REQUEST["responseCode"]; //responseCode Code For....
$_SESSION['status'] = $status;

$amount = $_REQUEST["paymentAmount"];
$metaData1 = $_REQUEST["metaData1"]; //Get Client Id
$merchantReferenceNo = $_REQUEST["metaData2"]; //Get Order Id

$client_id_hash = "roSNsM7De3MgTLeqQk4gSjTugzo";
$reqid_password = "weblook123";
$reqid = $_REQUEST['reqid'];

$reservations1 = new Reservations();
$reservations1->setReservationId($merchantReferenceNo);
$datares = $reservations1->getReservationsFromId();
$reservations1->extractor($datares);
$reservations1->reservationTotalPrice(); //Total amount
$reservations1->reservationHotelId(); //Total amount

$datacodevalue = $reservations1->reservationClientId() . '' . $reservations1->reservationTotalPrice() . '' . $reservations1->reservationHotelId();
$datacodevalue = md5($datacodevalue);

//error_log(var_export($_REQUEST, TRUE));

//error_log($datacodevalue);
//if ($metaData1 != $datacodevalue) {
//  die();
//}
//
if (isset($_REQUEST['reqid'])) {
    if ($metaData1 == $datacodevalue) {
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://test-merchants.paycorp.com.au/paycentre3/processEntry/" . $client_id_hash . "/" . $reqid_password . "/" . $reqid);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        parseXML($server_output);

        curl_close($ch);
        
    }
}

function parseXML($xml) {

    $data_array = xml_to_array($xml);

    if (isset($data_array['responseCode'])) {

        if ($data_array['responseCode'] == 00 || $data_array['responseCode'] == 08 || $data_array['responseCode'] == 77) {
            // success
            // echo "Success ";
            // echo $data_array['responseText'];
            $merchantReferenceNo = $_REQUEST["metaData2"]; //Get Order Id

            $reservations2 = new Reservations();
            $reservations2->setReservationId($merchantReferenceNo);
            $reservations2->setReservationPaymentStatus(1);
            $reservations2->updateReservationsOnlinePayment();
            $trans_msg = "Transaction Successful";

            $pay_data = $reservations2->getReservationsFromId();
            $reservations2->extractor($pay_data);
            $reservation_link_id = $reservations2->reservationFromBookingLink();


            if ($reservation_link_id == '1') {
                header("location:" . HTTP_PATH . "bookings/genpdf/invoices/hotel_voucher.php?resid=" . $merchantReferenceNo . "&force=email&redirect_to=" . HTTP_PATH . "bookings/room_confirmation.php");
            } else {
                header("location:" . HTTP_PATH . "bookings/genpdf/invoices/hotel_voucher.php?resid=" . $merchantReferenceNo . "&force=email&redirect_to=" . HTTP_PATH . "paymentstatus.php");
            }
        } else {
            // failed
            // echo "Failed ";
            // echo $data_array['responseText'];
            $merchantReferenceNo = $_REQUEST["metaData2"]; //Get Order Id

            $reservations = new Reservations();
            $reservations->setReservationId($merchantReferenceNo);
            $reservations->setReservationPaymentStatus(0);
            $reservations->updateReservationsOnlinePayment();
            $trans_msg = "Transaction unsuccessful, please try again";

            $pay_data = $reservations->getReservationsFromId();
            $reservations->extractor($pay_data);
            $reservation_link_id = $reservations->reservationFromBookingLink();


            if ($reservation_link_id == '1') {
                header("location:" . HTTP_PATH . "bookings/genpdf/invoices/hotel_voucher.php?resid=" . $merchantReferenceNo . "&force=email&redirect_to=" . HTTP_PATH . "bookings/room_confirmation.php");
            } else {
                header("location:" . HTTP_PATH . "bookings/genpdf/invoices/hotel_voucher.php?resid=" . $merchantReferenceNo . "&force=email&redirect_to=" . HTTP_PATH . "paymentstatus.php");
            }
        }
    }

    error_log(var_export($data_array, TRUE));
}

function xml_to_array($fulXml, $main_heading = '') {

    if (strpos($fulXml, '<?xml version="1.0" encoding="utf-8"?>') !== false) {
        $xml = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $fulXml);
    } else {
        $xml = str_replace('<?xml version="1.0"?>', '', $fulXml);
    }

    $deXml = simplexml_load_string($xml);
    $deJson = json_encode($deXml);
    $xml_array = json_decode($deJson, TRUE);
    if (!empty($main_heading)) {
        $returned = $xml_array[$main_heading];
        return $returned;
    } else {
        return $xml_array;
    }
}
