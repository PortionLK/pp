<?php
    define('_MEXEC', 'OK');
    require_once('../system/load.php');

// make invoice

//$payment_type = Sessions::getPaymentType();

    $payment_total = $_REQUEST['amount'];
    $inv_id = $_REQUEST['custom'];
    $item_number = $_REQUEST['item_number'];

    $payment_total = str_replace(",", "", $payment_total);

    $currency_code = "USD";

    if ($_SESSION['display_rate_in'] == "LKR") {
        $payment_total = number_format(Common::currencyConvert("LKR", "USD", $payment_total), 2);
    } else {
        $currency_code = $_SESSION['display_rate_in'];
    }

    /*print_r($_SESSION);
    print_r($_REQUEST);
    echo $payment_total;
    die();*/

// Include the paypal library
    include_once('PaymentGateway.php');
    include_once("Paypal.php");

// Create an instance of the paypal library
    $myPaypal = new Paypal();

// Specify your paypal email
//$myPaypal->addField('business', 'info@roomista.com');

//$myPaypal->addField('business', 'testmerchant101@gmail.com');
    $myPaypal->addField('business', 'info@roomista.com');

// Specify the currency
    $myPaypal->addField('currency_code', $currency_code);

// Specify the url where paypal will send the user on success/failure
    $myPaypal->addField('return', 'http://roomista.com/paypal/paypal_success.php');
    $myPaypal->addField('cancel_return', 'http://roomista.com/paypal/paypal_failure.php');

// Specify the url where paypal will send the IPN
    $myPaypal->addField('notify_url', 'http://roomista.com/paypal/paypal_ipn.php');

// Specify the product information
    $myPaypal->addField('item_name', 'Roomista - Invoice');
    $myPaypal->addField('amount', $payment_total);
    $myPaypal->addField('item_number', $item_number);

// Specify any custom value
    $myPaypal->addField('custom', $inv_id);

// Enable test mode if needed
//$myPaypal->enableTestMode();

// Let's start the train!
    $myPaypal->submitPayment();

?>