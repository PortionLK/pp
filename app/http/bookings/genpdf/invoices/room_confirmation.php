<?php
    define('_MEXEC', 'OK');
    require_once("../../../system/load.php");
    include("../pgconfig.php");

    $mainCity = new MainCity();
    $SubCity = new SubCity();
    $hotels = new Hotels();
    $session = new Sessions();
    $reservations = new Reservations();

    $mainCity_row = $mainCity->getMainCityFromHomePage();
    $mainCity_list = $mainCity->getMainCity();
    $hotels_row = $hotels->getHotelFromFeaturedStatus();
    $hotelsRecently_row = $hotels->getHotelRecentlyAdd();


    /*$transactionTypeCode=$_REQUEST["transaction_type_code"];
    $installments=$_REQUEST["installments"];
    $transactionId=$_REQUEST["transaction_id"];

    $amount=$_REQUEST["amount"];
    $exponent=$_REQUEST["exponent"];
    $currencyCode=$_REQUEST["currency_code"];*/
    $merchantReferenceNo = $session->getMerchantReferenceNo();


    /*$status=$_REQUEST["status"];
    $eci=$_REQUEST["3ds_eci"];
    $pgErrorCode=$_REQUEST["pg_error_code"];

    $pgErrorDetail=$_REQUEST["pg_error_detail"];
    $pgErrorMsg=$_REQUEST["pg_error_msg"];

    $messageHash=$_REQUEST["message_hash"];


    $messageHashBuf=$pgInstanceId."|".$merchantId."|".$transactionTypeCode."|".$installments."|".$transactionId."|".$amount."|".$exponent."|".$currencyCode."|".$merchantReferenceNo."|".$status."|".$eci."|".$pgErrorCode."|".$hashKey."|";

    $messageHashClient = "13:".base64_encode(sha1($messageHashBuf, true));

    $hashMatch=false;

    if ($messageHash==$messageHashClient){
      $hashMatch=true;
    } else {
      $hashMatch=false;
    }


    $trans_msg = "";

    if($status == '50020'){
        $reservations->setReservationId($merchantReferenceNo);
        $reservations->setReservationPaymentStatus(1);
        $reservations->updateReservationsOnlinePayment();
        $trans_msg = "Transaction Successful";
    }else{
        $reservations->setReservationId($merchantReferenceNo);
        $reservations->setReservationPaymentStatus(0);
        $reservations->updateReservationsOnlinePayment();
        $trans_msg = "Transaction unsuccessful, please try again";
    }*/
    $reservations->setReservationId($merchantReferenceNo);
    $pay_data = $reservations->getReservationsFromId();
    $reservations->extractor($pay_data);
    $reservation_link_id = $reservations->reservationFromBookingLink();
    $reservations_status = $reservations->reservationPaymentStatus();


    $bookingclient = new BookingClient();
    $bookingclient->setId($reservations->reservationClientId());
    $bookingclient->extractor($bookingclient->getClientsFromId());



?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html dir="ltr" lang="en-US" class="ie6"> <![endif]-->
<!--[if IE 7]>
<html dir="ltr" lang="en-US" class="ie7"> <![endif]-->
<!--[if IE 8]>
<html dir="ltr" lang="en-US" class="ie8"> <![endif]-->
<!--[if gt IE 8]><!-->
<html dir="ltr" lang="en-US"> <!--<![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Reservation</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/style.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/colours/blueblack.css" type="text/css"
          media="all"/>
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/responsive.css" type="text/css" media="all"/>

    <link
        href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic'
        rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,700,900' rel='stylesheet' type='text/css'/>

    <!-- JavaScript For IE -->

    <!--[if (gte IE 6)&(lte IE 8)]>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/selectivizr-min.js"></script>
    <![endif]-->

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body class="loading">
<div id="background-wrapper">
    <div id="wrapper">
        <div id="page-header" style="background:url(images/demo_image.jpg) no-repeat top center;">
            <!--<h2>Reservation: Complete Your booking</h2>-->
        </div>
        <div class="content-wrapper clearfix">
            <div class="booking-step-wrapper clearfix">

                <div class="step-wrapper">
                    <div class="step-icon-wrapper">
                        <div class="step-icon">1.</div>
                    </div>
                    <div class="step-title">Choose Your Date</div>
                </div>

                <div class="step-wrapper">
                    <div class="step-icon-wrapper">
                        <div class="step-icon">2.</div>
                    </div>
                    <div class="step-title">Choose Your Room</div>
                </div>

                <div class="step-wrapper">
                    <div class="step-icon-wrapper">
                        <div class="step-icon">3.</div>
                    </div>
                    <div class="step-title">Place Your Reservation</div>
                </div>

                <div class="step-wrapper last-col">
                    <div class="step-icon-wrapper">
                        <div class="step-icon step-icon-current">4.</div>
                    </div>
                    <div class="step-title">Confirmation</div>
                </div>
                <div class="step-line"></div>
            </div>

            <?php if ($reservations_status == 1) { ?>
                <div class="booking-main-wrapper">
                    <div class="booking-main">
                        <h4 class="title-style4">Reservation Complete<span class="title-block"></span></h4>

                        <p>Details of your reservation have just been sent to you in a confirmation email, we look
                            forward to seeing you soon. In the meantime if you have any questions feel free to contact
                            us.</p>
                        <ul class="contact_details_list contact_details_list_dark">
                            <li class="phone_list"><strong>Phone:</strong> +44 01234 56789</li>
                            <li class="fax_list"><strong>Fax:</strong> +44 98765 43210</li>
                            <li class="email_list"><strong>Email:</strong> email@website.com</li>
                        </ul>
                    </div>
                </div>
            <?php } else { ?>

                <div class="booking-main-wrapper">
                    <div class="booking-main">
                        <h4 class="title-style4">Transaction unsuccessful<span class="title-block"></span></h4>

                        <p>please try again.</p>
                        <ul class="contact_details_list contact_details_list_dark">
                            <li class="phone_list"><strong>Phone:</strong> +44 01234 56789</li>
                            <li class="fax_list"><strong>Fax:</strong> +44 98765 43210</li>
                            <li class="email_list"><strong>Email:</strong> email@website.com</li>
                        </ul>
                    </div>
                </div>

            <?php } ?>

            <div class="booking-side-wrapper">
                <div class="booking-side clearfix">
                    <h4 class="title-style4">Your Reservation<span class="title-block"></span></h4>
                    <ul>
                        <li><span>Client Name: </span> <?php echo $bookingclient->name(); ?></li>
                        <li>
                            <span>Address: </span>  <?php echo $bookingclient->address1() . "," . $bookingclient->address2(); ?>
                        </li>
                        <li><span>Email: </span><?php echo $bookingclient->email(); ?></li>
                        <li><span>Contact: </span><?php echo $bookingclient->contactno(); ?></li>
                        <li><span>Room: </span>
                            <?php
                                $rooms = new HotelRoomType();
                                $rooms->setRoomTypeId($reservations->reservationHotelRoomTypeId());
                                $rooms->extractor($rooms->getHotelRoomTypeFromId());
                                echo($rooms->roomTypeName()); ?></li>

                        <li><span>Check In: </span> <?php echo($reservations->reservationCheckInDate()); ?></li>
                        <li><span>Check Out: </span><?php echo($reservations->reservationCheckOutDate()); ?></li>
                        <li><span>Bed Type: </span> <?php //echo($reservations->reservationBedType()); ?>
                            <?php  if ($reservations->reservationBedType() == "sgl") {
                                echo "Single Bed";
                            }
                                if ($reservations->reservationBedType() == "dbl") {
                                    echo "Double Bed";
                                }
                                if ($reservations->reservationBedType() == "tpl") {
                                    echo "Tripple Bed";
                                }

                                if ($reservations->reservationBedType() == "") {
                                    echo "Not Selected";
                                }

                            ?>
                        </li>
                        <li><span>Meal Type: </span><?php //echo($reservations->reservationMealType()); ?>
                            <?php
                                if ($reservations->reservationMealType() == "bb") {
                                    echo "Bed & Breakfast";
                                }
                                if ($reservations->reservationMealType() == "hb") {
                                    echo "Half Board";
                                }
                                if ($reservations->reservationMealType() == "fb") {
                                    echo "Full Board";
                                }
                                if ($reservations->reservationMealType() == "ai") {
                                    echo "All Inclusive";
                                }
                                if ($reservations->reservationMealType() == "ro") {
                                    echo "Not Available";
                                }
                            ?>
                        </li>
                        <li><span>No Of Rooms: </span>  <?php echo($reservations->reservationNoOfRoom()); ?></li>
                    </ul>
                    <div class="price-details">

                        <p class="deposit">Total Price</p>


                        <h3 class="total-price"> <?php echo($reservations->reservationTotalPrice()); ?> <?php echo ($reservations->currencyType()) . " LKR"; ?> </h3>


                    </div>
                </div>
            </div>
        </div>
        <div id="footer"></div>
    </div>
</div>
<!-- JavaScript -->
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery-1.9.1.js"></script>
<script type='text/javascript' src='<?php echo HTTP_PATH; ?>js/jquery-ui.js'></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/superfish.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/scripts.js"></script>

<!-- END body -->
</body>
</html>