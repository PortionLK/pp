<?php
    define('_MEXEC', 'OK');
    require_once("system/load.php");


    $hotels = new Hotels();
    $reservations = new Reservations();

    $merchantReferenceNo = $_REQUEST['resid'];

    $reservations->setReservationId($merchantReferenceNo);
    $pay_data = $reservations->getReservationsFromId();
    $reservations->extractor($pay_data);
    $reservation_link_id = $reservations->reservationFromBookingLink();
    $reservations_status = $reservations->reservationPaymentStatus();

    $hotels->setHotelId($reservations->reservationHotelId());
    $hotels->extractor($hotels->getHotelFromId());
    $hotels_id = $reservations->reservationHotelId();

    $client = new Clients();
    $client->setClientId($reservations->reservationClientId());
    $client->extractor($client->getClientFromId());
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Roomista</title>
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/style.css" type="text/css"/>
    <!-- <link rel="shortcut icon" href="<?php echo HTTP_PATH; ?>images/favicon.ico">
    <link rel="icon" type="image/ico" href="<?php echo HTTP_PATH; ?>images/favicon.ico">-->
    <!--[if IE]>
    <link href="<?php echo HTTP_PATH; ?>css/ie.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="<?php echo HTTP_PATH; ?>favicon.ico">
    <link rel="icon" type="image/ico" href="<?php echo HTTP_PATH; ?>favicon.ico">
    <![endif]-->
    <!--[if IE 7]>
    <link href="<?php echo HTTP_PATH; ?>css/ie7.css" rel="stylesheet" type="text/css"/>
    <![endif]-->
    <!--[if IE 8]>
    <link href="<?php echo HTTP_PATH; ?>css/ie8.css" rel="stylesheet" type="text/css"/>
    <![endif]-->
    <!--[if IE 9]>
    <link href="<?php echo HTTP_PATH; ?>css/ie9.css" rel="stylesheet" type="text/css"/>
    <![endif]-->
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery-1.4.2.min.js"></script>
    <!-- jCarousel library -->
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery.jcarousel.min.js"></script>
    <!-- jCarousel skin stylesheet -->
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('#mycarousel').jcarousel();
        });
    </script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/includes/js-config.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/main.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/members.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/reservations.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/jquery.validate.js"></script>

</head>

<body>

<div id="wrapper">
    <?php include(DOC_ROOT . 'includes/header.php'); ?>
</div>
<!--end header-inner-->

<div id="content">
    <div class="content-inner">
        <?php include(DOC_ROOT . 'includes/hotel-catgories-inner.php'); ?>
        <div class="mid-sec">
            <!--end mid-left-sec-->
            <div class="sitemap-current-page"><!--Home <span class="color">> payment details</span>--></div>


            <h3 class="text-clr"><!--Guest and <span class="color-change">Payment Details  --></span></h3>

            <div style="margin-top:20px; background-color:#C93;">
                <div class="mid-left-forms">
                    <div class="contact-left-main">

                        <div class="contact-bold-text">E-mail:</div>
                        <div class="contact-normal-text">booking@roomista.com</div>

                        <!--<div class="contact-bold-text">Hot-line:</div>
                        <div class="contact-normal-text">011 4 347 444</div>-->

                        <div class="contact-bold-text">Tel:</div>
                        <div class="contact-normal-text">+94 (0) 777 555 832</div>
                        <div class="contact-bold-text">USA :</div>
                        <div class="contact-normal-text">+ 16 314801067</div>

                        <div class="contact-bold-text">UK :</div>
                        <div class="contact-normal-text">+ 02 070991876</div>

                        <div class="contact-bold-text">Australia :</div>
                        <div class="contact-normal-text">+ 03 86521714</div>

                        <div class="contact-bold-text">Address:</div>
                        <div class="contact-normal-text">Roomista (Pvt) Ltd<br/>
                            No 16/3 Cambridge Place, <br/>
                            Colombo 7.
                        </div>

                    </div>


                </div>
                <div id="payments">
                    <div align="center">
                        <?php if ($reservations_status == 1) { ?>
                            <h4 class="">Reservation Completed<span class="title-block"></span></h4>
                            <span style="color:#4A8ED0;">Details of your reservation have just been sent to you in a confirmation email, we look
                                forward to seeing you soon. In the meantime if you have any questions feel free to
                                contact us.</span>
                        <?php } else { ?>
                            <h4 class="">Transaction Unsuccessful<span class="title-block"></span></h4>
                            <span style="color:#4A8ED0;">Please try again.</span>
                        <?php } ?>
                        <?php
                            $currency_type = "";
                            //if (Sessions::currSuffix() == 'LKR') {
                            if (Sessions::getDisplayRatesIn() == 'LKR') {
                                $currency_type = 144;
                            } else {
                                $currency_type = 840;
                            }

                            $currencyCode = $currency_type;
                            $amount = Sessions::getOnlinePaymentRate();
                            $merchantReferenceNo = Sessions::getOnlinePaymentReservationId();

                            $messageHash = $pgInstanceId . "|" . $merchantId . "|" . $perform . "|" . $currencyCode . "|" . $amount . "|" . $merchantReferenceNo . "|" . $hashKey . "|";
                            $message_hash = "CURRENCY:7:" . base64_encode(sha1($messageHash, true));


                        ?>
                        <div style="visibility:hidden;">
                            <form name="pgtest" method="post" action="pgrequest.php">
                                <table>
                                    <tr>
                                        <td>Amount:</td>
                                        <td><input type="text" name="amount" value="<?php echo $amount ?>"/><!--(implied decimals)-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Currency</td>
                                        <td><input type="text" name="currency_code" value="<?php echo $currency_type ?>"/><!-- USD = 840 <br/> LKR = 144-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Merchant Reference No:</td>
                                        <td><input type="text" name="merchant_reference_no" value="<?php echo $merchantReferenceNo ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Order description:</td>
                                        <td><INPUT TYPE="text" name="order_desc" value="roomista online payment"></td>
                                    </tr>
                                    <tr style="display:none;">
                                        <td align="center" colspan="2">
                                            <input type="radio" name="perform" value="initiatePaymentCapture#sale" checked/> Sale &nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="perform" value="initiatePaymentCapture#preauth"/> Pre Auth
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" colspan="2">
                                            <input type="submit" value=" Pay Now"/>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>

                </div>
            </div>


            <!--end mid-right-sec-->
            <div class="clear"></div>
        </div>
        <!--end mid-sec-->
        <!--end after-mid-->
        <?php include(DOC_ROOT . 'includes/whyroomista-subscribe.php'); ?>


        <!--end befor-footer-->

        <div class="clear"></div>
    </div>
    <!--end content-inner-->
    <div class="clear"></div>
</div>
<!--end content-->
<?php include(DOC_ROOT . 'includes/footer.php'); ?>
<div class="clear"></div>
</div>
<!--end wrapper-->
<div class="clear"></div>
</body>
</html>
