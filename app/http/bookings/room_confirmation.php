<?php
    define('_MEXEC', 'OK');
    require_once("../system/load.php");
    include("../pgconfig.php");

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
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,700,900' rel='stylesheet' type='text/css'/>
    <!-- <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/style.css" type="text/css" media="all"/> -->
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/style_2.css" type="text/css" media="all"/>
    <!-- <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/styl1e-1.css" type="text/css" media="all"/> -->
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/style-2.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/colours/blueblack.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/responsive.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/lightbox.css" type="text/css" media="all"/>

    <!-- JavaScript For IE -->

    <!--[if (gte IE 6)&(lte IE 8)]>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/selectivizr-min.js"></script>
    <![endif]-->

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body class="loading">
<div id="background-wrapper">
    <div class="container">
    <div class="hotel_image" style="background-image:url(images/bg-image.jpg)"></div>
    <div class="hotel_name">
        <h2><?php echo $hotels->hotelName(); ?></h2>
        <h5><?php echo $hotels->hotelAddress(); ?></h5>
    </div> 
</div>
    <div id="wrapper">
        <?php
            $image_src = "uploads/direct-booking-images/" . "header-" . $hotels_id . ".jpg";
            if (file_exists(DOC_ROOT . $image_src)){
        ?>
                <div id="page-header" style="background:url(<?php echo HTTP_PATH . $image_src; ?>) no-repeat top center;">
            <?php
                }else{
            ?>
                    <div id="page-header" style="background:url(images/demo_image.jpg) no-repeat top center;">
                <?php } ?>
                <!--<h2>Reservation: Complete Your booking</h2>-->
            </div>
            <div class="content-wrapper clearfix">
                <div class="booking-step-wrapper clearfix">

                    <div class="step-wrapper">
                        <div class="step-icon-wrapper">
                            <div class="step-icon">1. Choose Your Date</div>
                        </div>
                        <div class="step-title"></div>
                    </div>

                    <div class="step-wrapper">
                        <div class="step-icon-wrapper">
                            <div class="step-icon">2. Choose Your Room</div>
                        </div>
                        <div class="step-title"></div>
                    </div>

                    <div class="step-wrapper">
                        <div class="step-icon-wrapper">
                            <div class="step-icon">3. Place Your Reservation</div>
                        </div>
                        <div class="step-title"></div>
                    </div>
                    <div class="step-wrapper last-col">
                        <div class="step-icon-wrapper">
                            <div class="step-icon step-icon-current">4. Confirmation</div>
                        </div>
                        <div class="step-title"></div>
                    </div>
                    <div class="step-line"></div>
                </div>
                <div class="booking-main-wrapper">
                    <div class="booking-main">
                        <?php if ($reservations_status == 1) { ?>
                        <h4 class="title-style4">Reservation Completed<span class="title-block"></span></h4>
                        <p>Details of your reservation have just been sent to you in a confirmation email, we look
                            forward to seeing you soon. In the meantime if you have any questions feel free to
                            contact us.</p>
                        <?php } else { ?>
                            <h4 class="title-style4">Transaction Unsuccessful<span class="title-block"></span></h4>
                            <p>please try again.</p>
                        <?php } ?>
                        <ul class="contact_details_list contact_details_list_dark">
                            <li class="phone_list"><strong>Phone: </strong>
                                <?php if($hotels->hotelPhone()!= ""){
                                        echo $hotels->hotelPhone();
                                    }else{
                                        echo '+94 (0) 777 555 832';
                                    }
                                ?>
                            </li>
                            <li class="email_list"><strong>Email:</strong>
                                <?php if($hotels->hotelEmail()!= ""){
                                        echo $hotels->hotelEmail();
                                    }else{
                                        echo 'booking@roomista.com';
                                    }
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
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
                            <li>
                                <span>Check In: </span> <?php echo(str_replace("00:00:00", "", $reservations->reservationCheckInDate())); ?>
                            </li>
                            <li>
                                <span>Check Out: </span><?php echo(str_replace("00:00:00", "", $reservations->reservationCheckOutDate())); ?>
                            </li>
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
                            <h3 class="total-price"> <?php echo number_format($reservations->reservationTotalPrice(), 2); ?> <?php echo($reservations->currencyType()); ?> </h3>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div id = "footer">
    <div class="container"><span class="copy">&copy; 2014 Roomista.com | All rights reserved</span></div>
</div> <!-- JavaScript -->
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery-1.9.1.js"></script>
    <script type='text/javascript' src='<?php echo HTTP_PATH; ?>js/jquery-ui.js'></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/superfish.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery.prettyPhoto.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/scripts.js"></script>
    <!-- END body -->
</body>
</html>