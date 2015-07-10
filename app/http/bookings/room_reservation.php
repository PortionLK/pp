<?php
    define('_MEXEC', 'OK');
    require_once("../system/load.php");
    $hotels_id = $_SESSION['hotels_id'];
    $check_in_date = $_SESSION['check_in_date'];
    $check_out_date = $_SESSION['check_out_date'];
    $book_room_adults = $_SESSION['book_room_adults'];
    $book_room_children = $_SESSION['book_room_children'];
    $room_type_id = $_REQUEST['room_type_id'];
    $numDays = $_REQUEST['numDays'];
    $room_bed_type = $_REQUEST['room_bed_type'];
    $_SESSION['room_bed_type'] = $_REQUEST['room_bed_type'];
    $room_meal_type = $_REQUEST['room_meal_type'];
    $_SESSION['room_meal_type'] = $_REQUEST['room_meal_type'];
    $no_of_room = $_REQUEST['no_of_room'];
    $_SESSION['no_of_room'] = $no_of_room;
    $room_type_id = $_REQUEST['room_type_id'];
    print("
        <script type='text/javascript'>
            var check_in_date='" . $check_in_date . "';
            var check_out_date='" . $check_out_date . "';
            var room_type_id='" . $room_type_id . "';
            var room_bed_type='" . $room_bed_type . "';
            var room_meal_type='" . $_SESSION['room_meal_type'] . "';
            var num_rooms='" . $no_of_room . "';
        </script>
    ");

    $hotel_room_type = new HotelRoomType();
    $hotel = new Hotels();
    $country = new country();

    $hotel->setHotelId($hotels_id);
    $hotel->extractor($hotel->getHotelFromId());

    $country->setCountryId($_SESSION['country_id']);

    $hotel_room_type->setRoomTypeId($room_type_id);

    $hotel_room_type->extractor($hotel_room_type->getHotelRoomTypeFromId());

    if ($hotels_id != $hotel_room_type->roomTypeHotelId()) {
        echo "Error";
        die();
    }

    $villa_type_id = 5;
?>
<!DOCTYPE html><!--[if lt IE 7]>
<html dir="ltr" lang="en-US" class="ie6"> <![endif]--><!--[if IE 7]>
<html dir="ltr" lang="en-US" class="ie7"> <![endif]--><!--[if IE 8]>
<html dir="ltr" lang="en-US" class="ie8"> <![endif]--><!--[if gt IE 8]><!-->
<html dir="ltr" lang="en-US" xmlns="http://www.w3.org/1999/html"> <!--<![endif]-->
<head>
<!--designing script-->
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/scripts.js"></script>
<script type='text/javascript' src='<?php echo HTTP_PATH; ?>js/jquery-ui.js'></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/superfish.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery.prettyPhoto.js"></script>
<!--end-->
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/includes/js-config.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/main.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/clients.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/messages.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/libs/jquery.hint.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/bookingclients.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/hotels.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>bookings/js/lightbox.min.js"></script>

<script type="text/javascript">
    $(document).ready(function (e) {
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

        setTimeout(function () {
            getRoomRateOnBookings(<?php echo $room_type_id?>);
            getOffers(check_in_date, check_out_date, room_type_id, room_bed_type, room_meal_type, num_rooms);
        }, 0);

        $('#terms').on('change',function(){
            $( "#paycard" ).prop( "disabled", !this.checked );
            $( "#paypaypal" ).prop( "disabled", !this.checked );
            $( "#paylater" ).prop( "disabled", !this.checked );
        });

        $("#client").validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                con_email_address: {
                    required: true,
                    email: true,
                    equalTo: "#email"
                },
                contactno: {
                    required: true,
                    number: true
                },
                address1: {
                    required: true
                },
                city: {
                    required: true
                },
                country: {
                    required: true
                },
                zipcode: {
                    number: true
                },
                address1: {
                    required: true
                }
            },
            messages: {
                name: "<span style='color: red;margin-top:-16px; padding-bottom:6px; display:block'>Please enter your name</span>",
                email: "<span style='color: red;margin-top:-16px; padding-bottom:6px; display:block'>Please enter a valid email</span>",
                con_email_address: "<span style='color: red;margin-top:-16px; padding-bottom:6px; display:block'>Email missmatched</span>",
                contactno: "<span style='color: red;margin-top:-16px; padding-bottom:6px; display:block'>Please enter your phone number</span>",
                country: "<span style='color: red;margin-top:-16px; padding-bottom:6px; display:block'>Please select your country</span>",
                city: "<span style='color: red;margin-top:-16px; padding-bottom:6px; display:block'>Please enter city</span>",
                zipcode: "<span style='color: red;margin-top:-16px; padding-bottom:9px; display:block'>Please enter a valid number</span>",
                address1: "<span style='color: red;margin-top:-16px; padding-bottom:6px; display:block'>Please enter your address</span>"
            },
            submitHandler: function () {
                addFrontClients()
            }
        });
    });
</script>

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Reservation</title>
<!-- Stylesheets -->
<link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,700,900' rel='stylesheet' type='text/css'/>

<!--<link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/style.css" type="text/css" media="all"/>-->
<link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/style_2.css" type="text/css" media="all"/>
<!--<link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/styl1e-1.css" type="text/css" media="all"/>-->
<link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/style-2.css" type="text/css" media="all"/>
<link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/colours/blueblack.css" type="text/css" media="all"/>
<link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/responsive.css" type="text/css" media="all"/>
<link rel="stylesheet" href="<?php echo HTTP_PATH; ?>bookings/css/lightbox.css" type="text/css" media="all"/>

<!-- JavaScript For IE --><!--[if (gte IE 6)&(lte IE 8)]>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/selectivizr-min.js"></script><![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<body class="loading">
<div id="background-wrapper">

<div class="container">
    <div class="hotel_image" style="background-image:url(images/bg-image.jpg)"></div>
    <div class="hotel_name">
        <h2><?php //echo $hotels->hotelName(); ?></h2>
        <h5><?php //echo $hotels->hotelAddress(); ?></h5>
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
</div>
<div class="content-wrapper clearfix">
<div class="booking-step-wrapper clearfix">
    <div class="step-wrapper">
        <div class="step-icon-wrapper">
            <div class="step-icon">1. Choose Your Date</div>
        </div>
    </div>
    <div class="step-wrapper">
        <div class="step-icon-wrapper">
            <div class="step-icon">2.
                <?php if ($hotel->hotelAccommodationType() == $villa_type_id) { ?>
                Choose Your Options
                <?php } else { ?>
                Choose Your Room
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="step-wrapper">
        <div class="step-icon-wrapper">
            <div class="step-icon step-icon-current">3.Place Your Reservation</div>
        </div>
    </div>
    <div class="step-wrapper last-col">
        <div class="step-icon-wrapper">
            <div class="step-icon">4. Confirmation</div>
        </div>
    </div>

    <div class="step-line"></div>
</div>
<input type="hidden" id="room_type_id" value="<?php echo $room_type_id; ?>"/>
<input type="hidden" id="no_of_room<?php echo $room_type_id; ?>" value="<?php echo $no_of_room; ?>"/>
<input type="hidden" id="room_meal_type<?php echo $room_type_id; ?>" value="<?php echo $room_meal_type; ?>"/>
<input type="hidden" id="room_bed_type<?php echo $room_type_id; ?>" value="<?php echo $room_bed_type; ?>"/>
<input type="hidden" id="numDays" value="<?php echo $numDays; ?>"/>
<input type="hidden" id="display_rate_in" value="<?php echo Sessions::getDisplayRatesIn(); ?>"/>

<div class="booking-main-wrapper">
    <div class="booking-main">
        <h4 class="title-style4">Guest Details<span class="title-block"></span></h4>
        <form class="clearfix" method="get" id="client" name="client">
            <div class="input-left">
                <label for="first_name">Full Name <span style="color: red;">*</span></label>
                <input type="text" name="name" id="name" class="send_data"/>
                <label for="email_address">Email Address <span style="color: red;">*</span></label>
                <input type="text" name="email" id="email" class="send_data"/>
                <label for="last_name">Confirm Email Address <span style="color: red;">*</span></label>
                <input type="text" name="con_email_address" id="con_email_address" class="send_data"/>
                <label for="phone_number">Contact Number <span style="color: red;">*</span></label>
                <input type="text" name="contactno" id="contactno" class="send_data"/>
                <label for="address_line1">Address Line 1 <span style="color: red;">*</span></label>
                <input type="text" name="address1" id="address1" class="send_data"/>
            </div>
            <div class="input-right">
                <label for="address_line2">Address Line 2</label>
                <input type="text" name="address2" id="address2" class="send_data"/>
                <label for="country">Country <span style="color: red;">*</span></label>
                <div class="select-wrapper" style="width: 94%;">
                    <select name="country" id="country" class="send_data" style="width: 100%; background-position: 97% center;">
                        <option value="">Select the Country</option>
                        <?php
                            $country_count = $country->getAllCountry();
                            for ($i = 0; $i < count($country_count); $i++) {
                                $country->extractor($country_count, $i); ?>
                                <option value="<?php echo($country->countryId()); ?>"><?php echo($country->countryName()); ?></option>
                            <?php } ?>
                    </select>
                </div>
                <label for="city">City <span style="color: red;">*</span></label>
                <input type="text" name="city" id="city" class="send_data"/>
                <label for="state_county">State/ Province</label>
                <input type="text" name="state" id="state" class="send_data"/>
                <label for="zip_postcode">Postal/ Zip</label>
                <input type="text" name="zipcode" id="zipcode" class="send_data" style="margin-bottom: 25px;"/>
            </div>
            <label for="special_requirements" style="display:block; ">Special Requirments</label>
            <textarea name="message" id="message" rows="10" class="send_data"></textarea>

            <p class="terms"><input type="checkbox" name="terms" id="terms"/> I have read and accept the
                <a target="_blank" href="<?php echo HTTP_PATH; ?>terms_and_conditions.php">terms and conditions</a>.
            </p>

            <p>
                <img src="<?php echo HTTP_PATH; ?>bookings/images/credit-card.png" width="141" height="60" style="margin-right: 58px;"/>
                <?php if ($_SESSION['display_rate_in'] != "LKR") { ?>
                    <img src="<?php echo HTTP_PATH; ?>bookings/images/paypal.png" width="141" height="60"/>
                <?php } ?>
            </p>

            <div class="clearfix"></div>
            <input type="hidden" id="paymenttype" value="2"/>
            <input class="form-button button3 bookbutton" type="button" id="paycard" disabled onClick="$('#paymenttype').val(2);$('#client').submit()" value="Pay with Credit Card"/>
            <?php if ($_SESSION['display_rate_in'] != "LKR") { ?>
                <input class="form-button button3 bookbutton" type="button" id="paypaypal" disabled onClick="$('#paymenttype').val(1);$('#client').submit()" value="Pay with Pay Pal"/>
            <?php } ?>
            <!--<input class="form-button" type="button" id="paylater" value="Pay Later" disabled onclick="$('#paymenttype').val(3);$('#client').submit();" style="margin-right: -2px;" />-->
            <span id="error_msg" style="color:#F00"></span>
        </form>
    </div>
</div>

<!-- //Paypal Form -->
<form id="payPalForm" name="payPalForm" action="<?php echo HTTP_PATH; ?>paypal/paypal_start.php" method="post" >
    <input type="hidden" name="amount" class="medium-input-logn" id="amount" style="width:150px;" autocomplete="off"/>
    <input type="hidden" name="item_number" id="item_number" value="<?php echo "{$no_of_room} - {$hotel_room_type->roomTypeName()} at {$hotel->hotelName()} for {$numDays} Days"; ?>">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="business" value="info@roomista.com">
    <input type="hidden" name="currency_code" value="<?php echo Sessions::getDisplayRatesIn(); ?>">
    <input type="hidden" name="return" value="<?php echo HTTP_PATH; ?>_controller?action=successPaymentReservation">
    <input type="hidden" name="custom" id="custom" value="">
    <input type="hidden" name="item_name" id="item_name" value="Roomista.com :: <?php echo "{$no_of_room} - {$hotel_room_type->roomTypeName()} at {$hotel->hotelName()} for {$numDays} Day(s)"; ?>" size="45">
</form>
<form id="paypal_payments" name="paypal_payments" style="display:none" action="../payments/paypal.php" method="post">
    <input type="text" id="total_amount1" name="total_amount1">
</form>
<!-- Paypal Form// -->
<!-- //IPG Form -->
<form id="ipg_payments" style="display:none">
    <input type="text" id="total_amount2" name="total_amount2" value="0">
</form>
<input type="hidden" name="amount2" class="medium-input-logn" id="amount2" style="width:150px;" autocomplete="off"/>
<!-- Paypal Form// -->
<div class="booking-side-wrapper">
    <div class="booking-side clearfix">
        <h4 class="title-style4">Your Reservation<span class="title-block"></span></h4>
        <ul>
            <li <?php if ($hotel->hotelAccommodationType() == $villa_type_id) { ?> style="display:none"  <?php } ?>   >
                <span>Room: </span><?php echo $hotel_room_type->roomTypeName(); ?>
            </li>
            <li>
                <span>Dates: </span><?php echo $check_in_date . ' - ' . $check_out_date; ?>
            </li>
            <li style="display:none;">
                <span>Guests: </span><?php echo $book_room_adults . ' Adults, ' . $book_room_children . ' Children'; ?>
            </li>
            <li>
                <span>Bed Type: </span>
                <?php  if ($_SESSION['room_bed_type'] == "sgl") {
                    echo "Single Bed";
                }
                    if ($_SESSION['room_bed_type'] == "dbl") {
                        echo "Double Bed";
                    }
                    if ($_SESSION['room_bed_type'] == "tpl") {
                        echo "Tripple Bed";
                    }
                    if ($_SESSION['room_bed_type'] == "") {
                        echo "Not Selected";
                    }
                ?>
            </li>
            <li>
                <span>Meal Type: </span>
                <?php
                    if ($_SESSION['room_meal_type'] == "bb") {
                        echo "Bed & Breakfast";
                    }
                    if ($_SESSION['room_meal_type'] == "hb") {
                        echo "Half Board";
                    }
                    if ($_SESSION['room_meal_type'] == "fb") {
                        echo "Full Board";
                    }
                    if ($_SESSION['room_meal_type'] == "ai") {
                        echo "All Inclusive";
                    }
                    if ($_SESSION['room_meal_type'] == "") {
                        echo "Not Selected";
                    }
                    if ($_SESSION['room_meal_type'] == "ro") {
                        echo "Not available";
                    }
                ?>
            </li>
            <li <?php if ($hotel->hotelAccommodationType() == $villa_type_id) { ?> style="display:none"  <?php } ?>   >
                <span>No Of Rooms: </span>
                <?php echo $_SESSION['no_of_room']; ?>
            </li>
            <li>
                <span>Country: </span>
                <?php
                    $country->setCountryId($_SESSION['country_id']);
                    $country->extractor($country->getCountryFromId());
                    echo $country->countryName();
                ?>
            </li>
            <li style="display: none;">
                <span>From: </span> $299 / Night
            </li>
        </ul>
        <div class="price-details">
            <div>
                <p class="deposit">Total Amount</p>

                <div>
                    <span id="sp_offer_netTotal">
                        <h3>Total</h3>
                        <h3 class="smallPrice total-price">
                            <span id="offer_netTotal"></span>
                        </h3>
                    </span>
                </div>
                <div id="li_offer_available">
                    <hr class="space8"/>
                    <center>
                        <a href="#" id="a_show_offer" class="title-style4">You are entitled for a special offer</a>
                    </center>
                    <br class="clear">
                </div>
                <div id="sp_offers">
                    <hr class="space8"/>
                    <span id="sp_offer_total">
                        <h3>Total</h3>
                        <h3 class="smallPrice total-price">
                            <span id="offer_total"></span>
                        </h3>
                    </span>
                    <span id="sp_offer_discount">
                        <h3>Offer Discount</h3>
                        <h3 class="smallPrice total-price">
                            <span id="offer_discount"></span>
                        </h3>
                    </span>
                    <span id="sp_offer_netTotal2">
                        <h3>Net Total</h3>
                        <h3 class="smallPrice total-price">
                            <span id="offer_netTotal2"></span>
                        </h3>
                    </span>
                    <span id="sp_offer_offer">
                        <h3>Offer Detail</h3>
                        <h3 class="smallPrice total-price">
                            <span id="offer_offer"></span>
                        </h3>
                    </span>
                </div>
            </div>
        </div>
        <?php //} ?>
        <hr class="space9"/>
        <a href="<?php echo HTTP_PATH . 'bookings/room_availability.php' ?>" class="button3 bookbutton">Edit Reservation</a>
    </div>
</div>
<div class="clearfix"></div>
<div class="content-wrapper clearfix gallery">
                <div class="mygallery" style="display:none">
                    <div>
                        <a class="example-image-link" href="<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_DSC_9864.jpg" data-lightbox="example-set" data-title="">
                            <img alt="Deluxe Room" src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_DSC_9864.jpg&w=206&h=153" />
                            <div class="hover"></div>
                        </a>
                        <span>Deluxe Room</span>

                    </div>
                    <div>
                        <a class="example-image-link" href="<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_DSC_0084.jpg" data-lightbox="example-set" data-title="">
                            <img alt="Standerd Room"  src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_DSC_0084.jpg&w=206&h=153"/>
                            <div class="hover"></div>
                        </a>
                        <span>Deluxe Room</span>
                    </div>
                    <div>
                        <a class="example-image-link" href="<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_Cranford_4.jpg" data-lightbox="example-set" data-title="">
                            <img alt="Standerd Room"  src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_Cranford_4.jpg&w=206&h=153"/>
                            <div class="hover"></div>
                        </a>
                        <span>Deluxe Room</span>
                    </div>
                    <div>
                        <a class="example-image-link" href="<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_Entrance.jpg" data-lightbox="example-set" data-title="">
                            <img alt="Standerd Room"  src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_Entrance.jpg&w=206&h=153"/>
                            <div class="hover"></div>
                        </a>
                        <span>Deluxe Room</span>
                    </div>
                    <div>
                        <a class="example-image-link" href="<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_Garden.jpg" data-lightbox="example-set" data-title="">
                            <img alt="Standerd Room" src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_Garden.jpg&w=206&h=153"/>
                            <div class="hover"></div>
                        </a>
                        <span>Deluxe Room</span>
                    </div>
                    <div>
                        <a class="example-image-link" href="<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_Cranford_4.jpg" data-lightbox="example-set" data-title="">
                            <img alt="Standerd Room" src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_Cranford_4.jpg&w=206&h=153"/>
                            <div class="hover"></div>
                        </a>
                        <span>Deluxe Room</span>
                    </div>
                    <div>
                        <a class="example-image-link" href="<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_Entrance.jpg" data-lightbox="example-set" data-title="">
                            <img alt="Standerd Room" src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/hotel-gal/353_Entrance.jpg&w=206&h=153"/>
                            <div class="hover"></div>
                        </a>
                        <span>Deluxe Room</span>
                    </div>
                </div>
            </div>

</div>

</div>
</div>
</div>
<div id="footer">
    <div class="container"><span class="copy">&copy; 2014 Roomista.com | All rights reserved</span></div>
</div>
<!-- JavaScript -->
</body>
</html>
<?php
    //echo $_SESSION['display_rate_in'];
?>