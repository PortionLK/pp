<?php
    define('_MEXEC', 'OK');
    require_once("system/load.php");

    if (!isset($_SESSION['login_client_id']) || isset($_SESSION['login_client_id']) && $_SESSION['login_client_id'] == "") {
        header('location:' . HTTP_PATH . 'clients/?q=l');
    }

    $hotel_id = $_REQUEST['hotel_id'];
    $room_type_id = $_REQUEST['room_type'];
    $reservation_id = $_REQUEST['reservation_id'];

    $hotels = new Hotels();

    $hotels->setHotelId($hotel_id);
    $hotel_data = $hotels->getHotelFromId();
    $hotels->extractor($hotel_data);

    $client = new Clients();
    $client->setClientId(Sessions::getClientId());
    $client->extractor($client->getClientFromId());

    $reservation=new Reservations();
    $reservation->setReservationId($reservation_id);
    $reservation->extractor($reservation->getReservationsFromId());

    $rooms = new HotelRoomType();
    $rooms->setRoomTypeId($reservation->reservationHotelRoomTypeId());
    $rooms->extractor($rooms->getHotelRoomTypeFromId());

    Sessions::setOnlinePaymentRate($reservation->reservationTotalPrice());
    Sessions::setOnlinePaymentReservationId($reservation_id);

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
        <!--end mid-sec-->
        <div class="mid-sec">
            <div class="left-col-wrap" style="width:550px; margin-left:250px;">
                <div class="form-title">Booking Details
                    <span class="title-block"></span>
                </div>
                <?php if (isset($_SESSION['login_client_id']) && $_SESSION['login_client_id'] != "") { ?>
                    <div class="booking-detail">
                        <ul>
                            <li><span>Client Name : </span> <?php echo($client->clientTitle() . ' ' . $client->clientFirstName() . ' ' . $client->clientLastName()); ?></li>
                            <li><span>Address: </span>  <?php echo($client->clientAddress()); ?></li>
                            <li><span>Email: </span> <?php echo($client->clientEmail());?></li>
                            <li><span>Contact: </span>  <?php echo($client->clientPhoneFixed());?></li>
                            <li><span>Hotel: </span> <?php echo ($hotels->hotelName()); ?></li>
                            <li><span>Check In: </span><?php echo date('Y-m-d',strtotime($reservation->reservationCheckInDate())); ?></li>
                            <li><span>Check Out: </span><?php echo date('Y-m-d',strtotime($reservation->reservationCheckOutDate())); ?></li>
                            <li><span>Room Type: </span> <?php echo($rooms->roomTypeName()); ?></li>
                            <li><span>Bed Type: </span>
                                <?php  if ($reservation->reservationBedType() == "sgl") {
                                        echo "Single Bed";
                                    }
                                    if ($reservation->reservationBedType() == "dbl") {
                                        echo "Double Bed";
                                    }
                                    if ($reservation->reservationBedType() == "tpl") {
                                        echo "Tripple Bed";
                                    }
                                    if ($reservation->reservationBedType() == "") {
                                        echo "Not Selected";
                                    }
                                ?>
                            </li>
                            <li><span>Meal Type: </span>
                                <?php
                                    if ($reservation->reservationMealType() =='ro'){
                                        echo "Room Only";
                                    }
                                    if ($reservation->reservationMealType() == "bb") {
                                        echo "Bed & Breakfast";
                                    }
                                    if ($reservation->reservationMealType() == "hb") {
                                        echo "Half Board";
                                    }
                                    if ($reservation->reservationMealType() == "fb") {
                                        echo "Full Board";
                                    }
                                    if ($reservation->reservationMealType() == "ai") {
                                        echo "All Inclusive";
                                    }
                                    if ($reservation->reservationMealType() == "") {
                                        echo "Not Selected";
                                    }
                                ?>
                            </li>
                            <li><span>No Of Rooms: </span><?php echo $reservation->reservationNoOfRoom(); ?></li>
                        </ul>
                        <div class="price-details">
                            <div class="total">Total Price</div>
                            <div class="total-price"> <?php echo $reservation->reservationTotalPrice(); ?> <?php echo $reservation->currencyType(); ?></div>
                            <div class="clear"></div>
                        </div>
                        <div style="height: 10px;"></div>

                        <?php
                            if($reservation->reservationOfferAvailable()==1){
                                $offer=unserialize(urldecode($reservation->reservationOfferData()));
                                if($offer['OfferAvailable']==true) {
                        ?>
                                    <div class="price-details">
                                        <div class="total">Offer Details</div>
                                        <div class="clear"></div>
                                        <hr/>
                                        <div class="total">Total Amount</div>
                                        <div class="total-price"> <?php echo ($reservation->currencyType() == 'LKR' ? $offer['TotalLKR'] : $offer['Total']) . ' ' . $reservation->currencyType(); ?></div>
                                        <div class="clear"></div>
                                        <div class="total">Offer Amount</div>
                                        <div class="total-price"> <?php echo ($reservation->currencyType() == 'LKR' ? $offer['TotalLKR']-$offer['DiscountedTotalLKR'] : $offer['Total']-$offer['DiscountedTotal']) . ' ' . $reservation->currencyType(); ?></div>
                                        <div class="clear"></div>
                                        <div class="total">Discounted Amount</div>
                                        <div class="total-price"> <?php echo ($reservation->currencyType() == 'LKR' ? $offer['DiscountedTotalLKR'] : $offer['DiscountedTotal']) . ' ' . $reservation->currencyType(); ?></div>
                                        <div class="clear"></div>
                                        <div class="total">Offer Details</div>
                                        <div class="total-price"> <?php echo $offer['Description']; ?></div>
                                        <div class="clear"></div>
                                    </div>
                                <?php
                                }elseif($offer['CustomOffer']==true){ ?>
                                    <div class="price-details">
                                        <div class="total">Offer Details</div>
                                        <div class="total-price"> <?php echo $offer['Custom'][0]['des']; ?></div>
                                        <div class="clear"></div>
                                    </div>
                                <?php }
                            }
                        ?>

                    </div>
                    <div class="form-row">
                        <?php if($reservation->reservationPaymentStatus()==0 & !(date("d/m/Y",strtotime($reservation->reservationCheckInDate()))<date("d/m/Y"))){ ?>
                            <!--<input type="button" name="paynow" value="Paynow" onclick="onlinePayment();" class="regbutton" style="float:right; margin-right: -267px;"/>-->
                            <input type="button" name="paynow" value="Paynow" onclick="window.location = http_path + 'payments.php';" class="regbutton" style="float:right; margin-right: -267px;"/>
                        <?php }else if($reservation->reservationPaymentStatus()==1){ ?>
                            <input type="button" disabled value="Paid" class="regbutton" style="float:right; margin-right: -267px; background-color: #252f38;"/>
                        <?php }else if(date("d/m/Y",strtotime($reservation->reservationCheckInDate()))<date("d/m/Y")){ ?>
                            <input type="button" disabled value="Expired" class="regbutton" style="float:right; margin-right: -267px; background-color: #252f38;"/>
                        <?php } ?>
                    </div>
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
