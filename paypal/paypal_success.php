<?php
    define('_MEXEC', 'OK');
    require_once('../system/load.php');

    header("location:" . HTTP_PATH . "bookings/genpdf/invoices/hotel_voucher.php?redirect_to=" . HTTP_PATH . "bookings/room_confirmation.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Paypal Success</title>
</head>
<body>
<h1>Paypal Success</h1>

<p>Thank you!</p>

<p>We have received your order and have started processing it. We will let you know as soon as it is being confirmed by
    Paypal.</p>
</body>
</html>