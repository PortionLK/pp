<?php
    define('_MEXEC', 'OK');
    require_once("../system/load.php");
    include("../pgconfig.php");

    $mainCity = new MainCity();
    $SubCity = new SubCity();
    $hotels = new Hotels();

    $mainCity_row = $mainCity->getMainCityFromHomePage();
    $mainCity_list = $mainCity->getMainCity();
    $hotels_row = $hotels->getHotelFromFeaturedStatus();
    $hotelsRecently_row = $hotels->getHotelRecentlyAdd();


    $transactionTypeCode = $_REQUEST["transaction_type_code"];
    $installments = $_REQUEST["installments"];
    $transactionId = $_REQUEST["transaction_id"];

    $amount = $_REQUEST["amount"];
    $exponent = $_REQUEST["exponent"];
    $currencyCode = $_REQUEST["currency_code"];
    $merchantReferenceNo = $_REQUEST["merchant_reference_no"];

    $status = $_REQUEST["status"];
    $eci = $_REQUEST["3ds_eci"];
    $pgErrorCode = $_REQUEST["pg_error_code"];

    $pgErrorDetail = $_REQUEST["pg_error_detail"];
    $pgErrorMsg = $_REQUEST["pg_error_msg"];

    $messageHash = $_REQUEST["message_hash"];


    $messageHashBuf = $pgInstanceId . "|" . $merchantId . "|" . $transactionTypeCode . "|" . $installments . "|" . $transactionId . "|" . $amount . "|" . $exponent . "|" . $currencyCode . "|" . $merchantReferenceNo . "|" . $status . "|" . $eci . "|" . $pgErrorCode . "|" . $hashKey . "|";

    $messageHashClient = "13:" . base64_encode(sha1($messageHashBuf, true));

    $hashMatch = false;

    if ($messageHash == $messageHashClient) {
        $hashMatch = true;
    } else {
        $hashMatch = false;
    }

    $reservations = new Reservations();
    $trans_msg = "";

    if ($status == '50020') {
        $reservations->setReservationId($merchantReferenceNo);
        $reservations->setReservationPaymentStatus(1);
        $reservations->updateReservationsOnlinePayment();
        $trans_msg = "Transaction Successful";
    } else {
        $reservations->setReservationId($merchantReferenceNo);
        $reservations->setReservationPaymentStatus(0);
        $reservations->updateReservationsOnlinePayment();
        $trans_msg = "Transaction unsuccessful, please try again";
    }


    $pay_data = $reservations->getReservationsFromId();
    $reservations->extractor($pay_data);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Roomista</title>
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/style.css" type="text/css"/>
    <!-- <link rel="shortcut icon" href="<?php echo HTTP_PATH; ?>images/favicon.ico">
<link rel="icon" type="image/ico" href="<?php echo HTTP_PATH; ?>images/favicon.ico">-->

    <!--[if IE]>
    <link href="<?php echo HTTP_PATH; ?>css/ie.css" rel="stylesheet" type="text/css"/>

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="icon" type="image/ico" href="/favicon.ico">

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
    <!--
      jCarousel library
    -->
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery.jcarousel.min.js"></script>
    <!--
      jCarousel skin stylesheet
    -->
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
    <div class="sitemap-current-page"><span class="color"></span></div>
    <h3 class="text-clr">Payment <span class="color-change">Details</span></h3>

    <div style="margin-top:20px; background-color:#C93;">
        <div id="payments">

            <div class="item">
                <div class="leftrow">Transaction Status</div>
                <div class="rightrow">: <?php echo($trans_msg); ?>
                </div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Client Name</div>
                <div class="rightrow">: <?php
                        $client = new Clients();
                        $client->setClientId($reservations->reservationClientId());
                        $client->extractor($client->getClientFromId());
                        echo($client->clientTitle() . ' ' . $client->clientFirstName() . ' ' . $client->clientLastName());?>
                </div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Address</div>
                <div class="rightrow">: <?php
                        echo($client->clientAddress());?></div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Email</div>
                <div class="rightrow">: <?php
                        echo($client->clientEmail());?></div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Contact</div>
                <div class="rightrow">: <?php
                        echo($client->clientPhoneFixed());?></div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Hotel</div>
                <div class="rightrow">: <?php
                        $hotels->setHotelId($reservations->reservationHotelId());
                        $hotel_data = $hotels->getHotelFromId();
                        $hotels->extractor($hotel_data);

                        echo($hotels->hotelName()); ?></div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Check In</div>
                <div class="rightrow">: <?php echo($reservations->reservationCheckInDate()); ?></div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Check Out</div>
                <div class="rightrow">: <?php echo($reservations->reservationCheckOutDate()); ?></div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Room Type</div>
                <div class="rightrow">:
                    <?php
                        $rooms = new HotelRoomType();
                        $rooms->setRoomTypeId($reservations->reservationHotelRoomTypeId());
                        $rooms->extractor($rooms->getHotelRoomTypeFromId());
                        echo($rooms->roomTypeName()); ?>
                </div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Bed Type</div>
                <div class="rightrow">: <?php echo($reservations->reservationBedType()); ?></div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Meal Type</div>
                <div class="rightrow">: <?php echo($reservations->reservationMealType()); ?></div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">No Of Rooms</div>
                <div class="rightrow">: <?php echo($reservations->reservationNoOfRoom()); ?></div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow">Room Rate</div>
                <div class="rightrow">
                    : <?php echo($reservations->reservationTotalPrice()); ?> <?php echo($reservations->currencyType()); ?></div>
                <div class="clear"></div>
            </div>

            <div class="item">
                <div class="leftrow"></div>
                <div class="rightrow">

                </div>
                <div class="clear"></div>
            </div>

            <div style="visibility:hidden;">
                <table>
                    <tr>
                        <td valign="top" align="center"><?
                                if ("50020" == $status) {
                                    ?>
                                    <font color="#339900"><b>Transaction Passed</b></font>
                                <?
                                } else if ("50097" == $status) {
                                    ?>
                                    <font color="#339900"><b>Test Transaction Passed</b></font>
                                <?
                                } else {
                                    ?>
                                    <font color="#FF0000"><b>Transaction Failed</b></font>
                                <?
                                }
                            ?></td>
                    </tr>
                    <tr>
                        <td valign="top" class="mainText">
                            <table border="1" width="400" align="center">
                                <tr>
                                    <td align="right">HashMatch</td>
                                    <td align="left">: <? echo $hashMatch; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">TransactionTypeCode</td>
                                    <td align="left">: <? echo $transactionTypeCode; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">TransactionId</td>
                                    <td align="left">: <? echo $transactionId; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">Amount</td>
                                    <td align="left">: <? echo $amount; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">Exponent</td>
                                    <td align="left">: <? echo $exponent; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">CurrencyCode</td>
                                    <td align="left">: <? echo $currencyCode; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">MerchantReferenceNo</td>
                                    <td align="left">: <? echo $merchantReferenceNo; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">Status</td>
                                    <td align="left">: <? echo $status; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">3dsEci</td>
                                    <td align="left">: <? echo $eci; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">PG ErrorCode</td>
                                    <td align="left">: <? echo $pgErrorCode; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">PG ErrorDetail</td>
                                    <td align="left">: <? echo $pgErrorDetail; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">PG ErrorMsg</td>
                                    <td align="left">: <? echo $pgErrorMsg; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!--end mid-right-sec-->
    <div class="clear"></div>
</div>
<!--end mid-sec-->
<!--end after-mid-->
<?php //include(DOC_ROOT.'includes/whyroomista-subscribe.php');?>

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
