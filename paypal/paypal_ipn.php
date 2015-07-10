<?php
    define('_MEXEC', 'OK');
    require_once('../system/load.php');

//file_put_contents('paypal.txt', "data:".$_REQUEST);
//die();

// Include the paypal library
    include_once('PaymentGateway.php');
    include_once('Paypal.php');

// Create an instance of the paypal library
    $myPaypal = new Paypal();

// Log the IPN results
    $myPaypal->ipnLog = FALSE;

// Enable test mode if needed
//$myPaypal->enableTestMode();

//$temp = implode(",",$_REQUEST);
//file_put_contents('paypal.txt', $temp  );

    $myPaypal->validateIpn();

// Check validity and write down it
//if ($myPaypal->validateIpn())
//{
    if ($myPaypal->ipnData['payment_status'] == 'Completed') {
        //file_put_contents('paypal.txt', 'SUCCESS\n\n' . $myPaypal->ipnData);
        //file_put_contents('paypal.txt', 'called');

        $reservations = new Reservations();
        $reservations->setReservationId($myPaypal->ipnData['custom']);
        $reservations->setReservationPaymentStatus(1);
        $reservations->updateReservationsOnlinePayment();

        header("location:" . HTTP_PATH . "bookings/genpdf/invoices/hotel_voucher.php?redirect_to=" . HTTP_PATH . "bookings/room_confirmation.php");

    } else {
        //file_put_contents('paypal.txt', "FAILURE\n\n" . $myPaypal->ipnData);
    }
    //}

