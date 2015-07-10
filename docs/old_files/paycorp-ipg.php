<?php
define('_MEXEC', 'OK');
require_once("system/load.php");

if (!isset($_SESSION['login_client_id']) || isset($_SESSION['login_client_id']) && $_SESSION['login_client_id'] == "") {
    header('location:' . HTTP_PATH . 'clients/?q=l');
}

$mainCity = new MainCity();
$SubCity = new SubCity();
$hotels = new Hotels();

$mainCity_row = $mainCity->getMainCityFromHomePage();
$mainCity_list = $mainCity->getMainCity();
$hotels_row = $hotels->getHotelFromFeaturedStatus();
$hotelsRecently_row = $hotels->getHotelRecentlyAdd();


$hotels->setHotelId(Sessions::getOnlinePaymentHotelId());
$hotel_data = $hotels->getHotelFromId();
$hotels->extractor($hotel_data);

$client = new Clients();
$client->setClientId(Sessions::getClientId());
$client->extractor($client->getClientFromId());

$rooms = new HotelRoomType();
$rooms->setRoomTypeId(Sessions::getOnlinePaymentRoomTypeId());
$rooms->extractor($rooms->getHotelRoomTypeFromId());
/* if(!isset($_SESSION['login_client_id']) || isset($_SESSION['login_client_id']) && $_SESSION['login_client_id'] ==""){
  header('location:'.HTTP_PATH.'clients/?q=l');
  } */

$day = 86400;
$startTime = strtotime(Sessions::getOnlinePaymentCheckin());
$endTime = strtotime(Sessions::getOnlinePaymentCheckOut());
$numDays = round(($endTime - $startTime) / $day);

print("
        <script type='text/javascript'>
            var check_in_date='" . Sessions::getOnlinePaymentCheckin() . "';
            var check_out_date='" . Sessions::getOnlinePaymentCheckOut() . "';
            var room_type_id='" . Sessions::getOnlinePaymentRoomTypeId() . "';
            var room_bed_type='" . Sessions::getOnlinePaymentBedType() . "';
            var room_meal_type='" . Sessions::getOnlinePaymentMealType() . "';
            var num_rooms='" . Sessions::getOnlinePaymentRoomCount() . "';
        </script>
    ");

Sessions::getClientId(); //client ID

$session = new Sessions();

//print_r($_SESSION);

$online_payment_res_id = $_SESSION['online_payment_res_id']; //$reservationsid

$reservations = new Reservations();
$reservations->setReservationId($online_payment_res_id);
$datares = $reservations->getReservationsFromId();
$reservations->extractor($datares);
$reservations->reservationTotalPrice(); //Total amount
$reservations->reservationHotelId(); //Total amount

$datacodevalue = Sessions::getClientId() . '' . $reservations->reservationTotalPrice() . '' . $reservations->reservationHotelId();
//echo '<br>';
$mdencodevalue = md5($datacodevalue);
//echo '<br>';
//echo $mdencodevalue = base64_decode($mdencodevalue);
//die();
?>
<style>
    .clearfix.input-button-box {
        border-top: none;
        height: 470px !important;
    }
</style>

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
        <!--
          jCarousel library
        -->
    <!--    <script type="text/javascript" src="--><?php //echo HTTP_PATH;                                                                                             ?><!--js/jquery.jcarousel.min.js"></script>-->
        <!--
          jCarousel skin stylesheet
        -->

        <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/includes/js-config.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/main.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/members.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/reservations.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/jquery.validate.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/hotels.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/reservations.js"></script>


        <link rel = "stylesheet" href = "<?php echo HTTP_PATH; ?>css/smoothness-dialog/jquery-ui-1.10.4.custom.css">
            <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/res-style.css" type="text/css" media="all" />
            <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/colours/blueblack.css" type="text/css" media="all"/>
            <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/style.css" type="text/css"/>
            <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/modal-dialog.css" type="text/css"/>
            <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/framework.css" type="text/css">
                <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/lightbox.css" type="text/css">
                    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/bookin-style.css" type="text/css">

                        <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/bjqs.css">
                            <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/bjqs.style.css">
                                <link type = 'text/css' href = '<?php echo HTTP_PATH; ?>css/jquery.simplemodal.css' rel = 'stylesheet' media = 'screen' />

                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $("#li_offer_available").hide();
                                        $("#sp_offer_total").hide();
                                        $("#sp_offer_discount").hide();
                                        $("#sp_offer_netTotal").hide();
                                        $("#sp_offer_netTotal2").hide();
                                        $("#sp_offer_offer").hide();
                                        $("#sp_offers").hide();
                                        var show_offers = false;

                                        $('#a_show_offer').click(function (e) {
                                            if (show_offers == false) {
                                                $("#sp_offers").slideDown().slow;
                                                show_offers = true;
                                            } else {
                                                $("#sp_offers").slideUp().slow;
                                                show_offers = false;
                                            }
                                            e.preventDefault();
                                        });

                                        getRoomRateOnBookings(room_type_id);
                                        getOffers(check_in_date, check_out_date, room_type_id, room_bed_type, room_meal_type, num_rooms);

                                        $('#terms').on('change', function () {
                                            $("#paycard").prop("disabled", !this.checked);
                                            $("#paypaypal").prop("disabled", !this.checked);
                                            $("#paylater").prop("disabled", !this.checked);
                                            $("#payipg").prop("disabled", !this.checked);
                                        });
                                    });

                                    //        jQuery(document).ready(function () {
                                    //            jQuery('#mycarousel').jcarousel();
                                    //        });
                                </script>

                                </head>
                                <body>
                                    <div id="wrapper">
                                        <?php include(DOC_ROOT . 'includes/header.php'); ?>
                                    </div>
                                    <!--end header-inner-->

                                    <div id="content">
                                        <div class="content-inner">
                                            <?php include(DOC_ROOT . 'includes/hotel-catgories-inner.php'); ?>
                                            <!--end mid-sec-->
                                            <div class="mid-sec">
                                                <div class="left-col-wrap" style="width:550px; margin-left:250px;">
                                                    <div class="form-title">Payments Details
                                                        <span class="title-block"></span>
                                                    </div>
                                                    <?php if (isset($_SESSION['login_client_id']) && $_SESSION['login_client_id'] != "") { ?>
                                                        <div id="paymentiframe">
                                                            <!-- PayMent Form 
                                                            <iframe id="test_id" src="https://test-merchants.paycorp.com.au/paycentre3/showEntry?clientIdHash=roSNsM7De3MgTLeqQk4gSjTugzo&paymentAmount=<?php echo $reservations->reservationTotalPrice(); ?>&metaData1=<?php echo Sessions::getClientId(); ?>&metaData2=<?php echo $online_payment_res_id; ?>" width="400" height="300"></iframe> 
                                                            --> <!-- PayMent Form   <form id="bookroom" method="POST" class="booking-form" action="https://test-merchants.paycorp.com.au/paycentre3/makeEntry" style="margin: auto 98px">//-->


                                                            <form id="bookroom" method="POST" class="booking-form" action="https://test-merchants.paycorp.com.au/paycentre3/makeEntry?clientIdHash=roSNsM7De3MgTLeqQk4gSjTugzo" style="margin: auto 98px">
                                                                <div class="clearfix input-button-box">
                                                                    <div class="datePickers">

                                                                        <div class="col">
                                                                            <label for="check_in_date" style="color:#333">Client Name</label>
                                                                            <input id="cardHolderName" type="text" name="cardHolderName" size="20" autocomplete="off" maxlength="50"  style="width:100%"  required>
                                                                                <div class="clearfix"></div>
                                                                        </div>

                                                                        <div class="col">
                                                                            <label for="check_in_date" style="color:#333">Select Card Type</label>

                                                                            <select id="cardType" name="cardType" valign="cardType" style="width: 100%">
                                                                                <option value="VISA" selected>VISA</option>
                                                                                <option value="MASTERCARD">MASTERCARD</option>
                                                                            </select>
                                                                            <div class="clearfix"></div>
                                                                        </div>

                                                                        <div class="col">
                                                                            <label for="check_in_date" style="color:#333">Card No</label>
                                                                            <input id="cardNo" type="text" name="cardNo" size="20" autocomplete="off" maxlength="16" style="width: 100%"  required>
                                                                                <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="check_in_date" style="color:#333">CVC</label>
                                                                            <input id="cardSecureId" type="text" name="cardSecureId" size="4" autocomplete="off" maxlength="4" style="width: 100%"  required>
                                                                                <div class="clearfix"></div>
                                                                        </div>


                                                                        <div class="one-half-form">
                                                                            <label for="check_in_date" style="color:#333">Month</label>
                                                                            <select id="cardExpiryMM" name="cardExpiryMM" valign="cardExpiryMM">

                                                                                <?php
                                                                                //$M = date("M");
                                                                                for ($i = 0; $i <= 12; $i++) {
                                                                                    if ($i < 10) {
                                                                                        $val = "0" . $i;
                                                                                    } else {
                                                                                        $val = $i;
                                                                                    }
                                                                                    ?>
                                                                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <div class="clearfix"></div> <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="one-half-form last-col">
                                                                            <label for="check_out_date" style="color:#333">Year</label>

                                                                            <select id="cardExpiryYYYY" name="cardExpiryYYYY" valign="cardExpiryYYYY">
                                                                                <?php
                                                                                $year = date("Y");
                                                                                $exdate = date("Y", strtotime("+ 3650 day"));
                                                                                for ($i = $year; $i <= $exdate; $i++) {
                                                                                    //$date = '20' . $i;
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="clearfix"></div> <div class="clearfix"></div>



                                                                        <div class="last-col">
                                                                            <label for="check_in_date" style="color:#333">Amount</label>
                                                                            <h2><?php echo $reservations->reservationTotalPrice(); ?></h2>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <div class="clearfix"></div> <div class="clearfix"></div> <div class="clearfix"></div>

                                                                        <input name="metaData1" id="metaData1"  value="<?php echo $mdencodevalue; ?>" type="hidden" />
                                                                        <input name="metaData2" id="metaData2"  value="<?php echo $online_payment_res_id; ?>" type="hidden" />
                                                                        <input name="paymentAmount" id="paymentAmount"  value="<?php echo $reservations->reservationTotalPrice(); ?>" type="hidden" />
                                                                        <input type="submit" id="checkRooms" value="Payment Submit" class="bookbutton pull-right">
                                                                    </div>
                                                            </form><!-- Send data to PDF http://roomista.com/bookings/genpdf/invoices/hotel_voucher.php?resid=284&force=view -->



                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <style> 
                                                            #submitBtn{color: red ima;} 
                                                        </style>
                                                    <?php } else { ?>
                                                        <div class="item">
                                                            <div class="leftrow"></div>
                                                            <div class="rightrow">Please Sign-in or Register to make Payment</div>
                                                            <div class="clear"></div>
                                                        </div>
                                                    <?php } ?>

                                                </div>
                                            </div>

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
