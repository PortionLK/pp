<?php
    define('_MEXEC', 'OK');
    require_once("../system/load.php");

    $hotels = new Hotels();
    $sessions = new Sessions();
    $hotelRoomRates = new HotelRoomRates();
    $hotelRoomType = new HotelRoomType();
    $roomcontrol = new RoomControl();
    $hotels_id = $_SESSION['hotels_id'];

    if (!isset($_REQUEST['check_in_date'])) {
        $_SESSION['country_id'] = $_SESSION['country_id'];
        $_SESSION['rc_num_of_rooms'] = $_SESSION['rc_num_of_rooms'];
        $_SESSION['check_in_date'] = $_SESSION['check_in_date'];
        $_SESSION['check_out_date'] = $_SESSION['check_out_date'];
        $_SESSION['book_room_adults'] = $_SESSION['book_room_adults'];
        $_SESSION['book_room_children'] = $_SESSION['book_room_children'];
    } else {
        $_SESSION['country_id'] = $_REQUEST['country_id'];
        $_SESSION['rc_num_of_rooms'] = $_REQUEST['rc_num_of_rooms'];
        $_SESSION['check_in_date'] = $_REQUEST['check_in_date'];
        $_SESSION['check_out_date'] = $_REQUEST['check_out_date'];
        $_SESSION['book_room_adults'] = $_REQUEST['book_room_adults'];
        $_SESSION['book_room_children'] = $_REQUEST['book_room_children'];
    }

    $hotels->setHotelId($hotels_id);
    $hotels->extractor($hotels->getHotelFromId());
    $Sessions->setSearchSessions($_SESSION['search_num_of_room'], $_SESSION['search_adults'], $_SESSION['search_children'], $_SESSION['check_in_date'], $_SESSION['check_out_date'], $_SESSION['no_of_dates']);

    $day = 86400;
    $startTime = strtotime($_SESSION['check_in_date']);
    $endTime = strtotime($_SESSION['check_out_date']);
    $numDays = round(($endTime - $startTime) / $day);

    $from_date = date('Y-m-d', strtotime($_SESSION['check_in_date']));
    $to_date = date('Y-m-d', strtotime($_SESSION['check_out_date']));
    $room_count_empty = 0;
    $hotelRoomType->setRoomTypeHotelId($hotels_id);
    $getRoomType_row = $hotelRoomType->getHotelRoomTypeFromHotelsId();

    $villa_type_id = 5;
    //$_SESSION['display_rate_in'] = "USD";

?>
<!DOCTYPE html><!--[if lt IE 7]>
<html dir = "ltr" lang = "en-US" class = "ie6"> <![endif]--><!--[if IE 7]>
<html dir = "ltr" lang = "en-US" class = "ie7"> <![endif]--><!--[if IE 8]>
<html dir = "ltr" lang = "en-US" class = "ie8"> <![endif]--><!--[if gt IE 8]><!-->
<html dir = "ltr" lang = "en-US"> <!--<![endif]-->
<head>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0" />
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

<link type = 'text/css' href = '../css/jquery.simplemodal.css' rel = 'stylesheet' media = 'screen' />
<link rel = "stylesheet" href = "//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/bjqs.css">
<link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/bjqs.style.css">

<meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" />

<!-- JavaScript -->
<script type = "text/javascript" src = "<?php echo HTTP_PATH; ?>system/includes/js-config.js"></script>
<script type = "text/javascript" src = "<?php echo HTTP_PATH; ?>bookings/js/jquery-1.9.1.js"></script>
<script type = 'text/javascript' src = '<?php echo HTTP_PATH; ?>bookings/js/jquery-ui.js'></script>
<script type = "text/javascript" src = "<?php echo HTTP_PATH; ?>bookings/js/superfish.js"></script>
<script type = "text/javascript" src = "<?php echo HTTP_PATH; ?>bookings/js/jquery.prettyPhoto.js"></script>
<script type = "text/javascript" src = "<?php echo HTTP_PATH; ?>bookings/js/scripts.js"></script>
<script type="text/javascript" src="<?php echo HTTP_PATH; ?>bookings/js/lightbox.min.js"></script>


<script src = "//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script src="<?php echo HTTP_PATH; ?>js/bjqs-1.3.min.js"></script>

<script type = "text/javascript" src = "<?php echo HTTP_PATH; ?>system/js/main.js"></script>
<script type = "text/javascript" src = "<?php echo HTTP_PATH; ?>system/js/hotels.js"></script>

<script type = "text/javascript">
    $(document).ready(function () {

        //INFO: Modal Dialog
        $(".basic-modal-content").dialog({
            autoOpen: false,
            modal: true,
            width: '70%',
            resizable: false,
            fluid: true,
            show: {effect: "fade", duration: 150},
            hide: {effect: "fade", duration: 150}
        });

        $(".a_room_info").click(function (e) {

            if($('div#banner-fade-'+$(this).data("roomid")+' img').length>1) {
                $('#banner-fade-' + $(this).data("roomid")).bjqs({
                    animtype: 'fade',
                    automatic: true,
                    showmarkers: false,
                    nexttext: '&#62;',
                    prevtext: '&#60;',
                    animduration: 450,
                    animspeed: 2000,
                    responsive: false,
                    randomstart: true,
                    keyboardnav: true,
                    hoverpause: true
                });
            }else{
                $('#banner-fade-' + $(this).data("roomid")).bjqs({
                    automatic: false
                });
            }
//                    $('#banner-fade-'+$(this).data("roomid")).bjqs({
//                        animtype        : 'fade',
//                        showmarkers     : false,
//                        nexttext        : '&#62;',
//                        prevtext        : '&#60;',
//                        animduration    : 450,
//                        animspeed       : 2000,
//                        responsive    : false,
//                        randomstart   : true
//                    });

            $("#" + $(this).data("dialog")).dialog("open");
            e.preventDefault();
        });

        var responsive = true;
        var isTouch = $("html").hasClass("touch");

        // resize on window resize
        $(window).on("resize", function () {
            resize();
        });

        // resize on orientation change
        window.addEventListener("orientationchange", function () {
            resize();
        });

        // responsive width & height
        var resize = function () {
            // check if responsive
            // dependent on modernizr for device detection / html.touch
            if (responsive === true || (responsive === "touch" && isTouch)) {
                $(".basic-modal-content").each(function () {
                    $(this).dialog("option", "position", "center");
                    $(this).css("overflow", "auto");
                });
            }
        };
        //INFO: Modal Dialog//

    });

    function bookNow(id) {
        var numDays = document.getElementById("numDays").value;
        var room_bed_type = document.getElementById("room_bed_type" + id).value;
        var room_meal_type = document.getElementById("room_meal_type" + id).value;
        var no_of_room = document.getElementById("no_of_room" + id).value;
        window.location = "room_reservation.php?room_bed_type=" + room_bed_type + "&room_meal_type=" + room_meal_type + "&no_of_room=" + no_of_room + "&numDays=" + numDays + "&room_type_id=" + id;
    }
    setTimeout(function () {
        refreshCurrency()
    }, 1000);

</script>
<!-- JavaScript For IE --><!--[if (gte IE 6)&(lte IE 8)]>
<script type = "text/javascript" src = "<?php echo HTTP_PATH; ?>js/selectivizr-min.js"></script><![endif]-->
</head>

<body class = "loading">
<div id = "background-wrapper">

<div class="container">
    <div class="hotel_image" style="background-image:url(images/bg-image.jpg)"></div>
    <div class="hotel_name">
        <h2><?php echo $hotels->hotelName(); ?></h2>
        <h5><?php echo $hotels->hotelAddress(); ?></h5>
    </div> 
</div>

<div id = "wrapper">
<?php
    $image_src = "uploads/direct-booking-images/" . "header-" . $hotels_id . ".jpg";
    if (file_exists(DOC_ROOT . $image_src)){
?>
        <div id = "page-header" style = "background:url(<?php echo HTTP_PATH . $image_src; ?>) no-repeat top center;">
<?php
    }else{
?>
<div id = "page-header" style = "background:url(images/demo_image.jpg) no-repeat top center;">
    <?php } ?>
    <!--<h2>Reservation: Choose Your Room</h2>-->
</div>
<div class = "content-wrapper clearfix">
    <div class = "booking-step-wrapper clearfix">
        <div class = "step-wrapper">
            <div class = "step-icon-wrapper">
                <div class = "step-icon">1. Choose Your Date</div>
            </div>
        </div>
        <div class = "step-wrapper">
            <div class = "step-icon-wrapper">
                <div class="step-icon step-icon-current">2. 
                <?php if ($hotels->hotelAccommodationType() == $villa_type_id) { ?>
                Choose Your Options
                <?php } else { ?>
                    Choose Your Room
                <?php } ?>
                </div>
            </div>
        </div>
        <div class = "step-wrapper">
            <div class = "step-icon-wrapper">
                <div class = "step-icon">3. Place Your Reservation</div>
            </div>
        </div>
        <div class = "step-wrapper last-col">
            <div class = "step-icon-wrapper">
                <div class = "step-icon">4. Confirmation</div>
            </div>
        </div>
        <div class = "step-line"></div>
    </div>

    <div class = "booking-main-wrapper">
        <div class = "booking-main">
            <?php if ($hotels->hotelAccommodationType() == $villa_type_id) { ?>
                <h4 class = "title-style4">Choose Your Options<span class = "title-block"></span></h4>
            <?php } else { ?>
                <h4 class = "title-style4">Choose Your Room<span class = "title-block"></span></h4>
            <?php } ?>
            <div style = "text-align:right">
                <span style = "font-size:12px">Display Rates in :</span>
                <?php
                    //$currency_list = array("LKR" => 'Sri Lankan Rupee (LKR)', "USD" => 'US Dollars (USD)', "GBP" => 'British Pound (GBP)',);
                    $currency_list = array("USD" => 'US Dollars (USD)', "LKR" => 'Sri Lankan Rupee (LKR)');
                ?>
                <select id = "display_rate_in" onchange = "refreshCurrency()">
                    <?php foreach ($currency_list as $ck => $cv) { ?>
                        <option <?php if (isset($_SESSION['display_rate_in']) && $_SESSION['display_rate_in'] == $ck) {
                            echo "selected=selected";
                        } else {
                            if ($ck == "USD") {
                                echo "selected=selected";
                            }
                        } ?> value = "<?php echo $ck; ?>"><?php echo $cv; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div style = "font-size:13px;margin-top:10px;margin-bottom:10px;line-height: normal; display:none"><?php echo $hotels->hotelDescription(); ?></div>
            <ul class = "room-list-wrapper clearfix">
            <?php
                for ($k = 0; $k < count($getRoomType_row); $k++) {
                    $hotelRoomType->extractor($getRoomType_row, $k);
                    /* new room check */
                    $no_of_rooms = 0;
                    $all_dates_available = true;
                    $rc_in_date = $from_date;
                    $rc_out_date = $to_date;
                    $room_control = new RoomControl();
                    $_temp = $room_control->getAllRoomDates($rc_in_date, $rc_out_date, $hotelRoomType->roomTypeId());
                    $number_array = array();
                    for ($i = 0; $i < count($_temp); $i++) {
                        $room_control->extractor($_temp, $i);
                        if ($room_control->rcNumOfRooms() == 0) {
                            $all_dates_available = false;
                        }
                        array_push($number_array, $room_control->rcNumOfRooms());
                    }
                    sort($number_array);
                    $no_of_rooms = $number_array[0];
                    if (!$all_dates_available) {
                        $no_of_rooms = 0;
                    }
                    $roomsCount = $no_of_rooms;

                $roomType = new HotelRoomType();
                $roomTypeData = $roomType->getHotelRoomTypeFromHotelRoomtypeId($hotelRoomType->roomTypeHotelId(), $hotelRoomType->roomTypeId());
                $roomType->extractor($roomTypeData);
                ?>
                <script type="text/javascript">
                    $(document).ready(function(e) {
                        ///var room_type_id = $("#room_type_id").val();
                        //getRoomRateOnBookings(<?php echo $hotelRoomType->roomTypeId();?>);
                        //getAvailableBeds(<?php echo $hotelRoomType->roomTypeId();?>);
                    });
                </script>
                <!--INFO: Modal Popup -->
                <div class = "basic-modal-content" id = "basic-modal-content<?php echo $hotelRoomType->roomTypeId(); ?>">
                    <div class = "content">
                        <div class = "left-col">
                            <h4>Room Type: <?php echo $hotelRoomType->roomTypeName(); ?></h4>
                            <div class = "left-col-upper">
                                <!-- Slider -->
                                <!--  Outer wrapper for presentation only, this can be anything you like -->
                                <div class="banner-fade" id="banner-fade-<?php echo $hotelRoomType->roomTypeId(); ?>">
                                    <!-- start Basic Jquery Slider -->
                                    <ul class="bjqs" id="bjqs-<?php echo $hotelRoomType->roomTypeId(); ?>">
                                        <?php if ($hotelRoomType->roomTypeImg() != "") { ?>
                                            <li><img title = "" src = '<?php echo HTTP_PATH; ?>uploads/room/<?php echo $hotelRoomType->roomTypeImg(); ?>' /></li>
                                        <?php }
                                            print("
                                                <script type='text/javascript'>
                                                    loadRoomImagesForSlider('" . $hotelRoomType->roomTypeId() . "','bjqs-" . $hotelRoomType->roomTypeId() . "');
                                                </script>
                                            "); ?>
                                    </ul>
                                    <!-- end Basic jQuery Slider -->

                                </div>
                                <!-- End outer wrapper -->

                                <!-- //Slider -->
                            </div>
                            <div class = "left-col-lower">
                                <ul>
                                    <?php
                                        echo '<li><span class="text"> Max Persons: ' . $roomType->roomTypeMaxPersons() . '</span></li>';
                                        if($roomType->roomTypeMaxExtraBeds()==0) {
                                            echo '<li><span class="text">Extra beds are not available for this room.</span></li>';
                                        }else {
                                            echo '<li><span class="text">Max Extra Beds: ' . $roomType->roomTypeMaxExtraBeds() . '</span></li>';
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class = "right-col">
                            <?php
                                $offers=new Offers();
                                $offerArr=$offers->getAvailableOffers($rc_in_date, $rc_out_date, $hotelRoomType->roomTypeId());
                            ?>
                            <h4>Room Facilities</h4>
                            <div class = "right-col-upper height1">
                                <ul>
                            <?php
                                $roomFeatures = new RoomFeatures();
                                $roomFeatures_rows = $roomFeatures->getAllRoomFeatures();

                                $featurs_list = $roomType->roomTypeFeatures();
                                $list_array = array_filter(explode(',', $featurs_list));

                                foreach ($list_array as $roomFeatureId) {
                                    $roomFeatures->setRoomFeatureId($roomFeatureId);
                                    $roomFeatures_rows = $roomFeatures->getRoomFeaturesFromId();
                                    $roomFeatures->extractor($roomFeatures_rows);
                                    echo '<li><span class="text">' . $roomFeatures->roomFeatureName() . '</span></li>';
                                }
                            ?>
                                </ul>
                            </div>
                            <div class = "right-col-lower">

                            </div>
                        </div>
                    </div>
                </div>
                <!--INFO: Modal Popup// -->
                <!--repeated area start-->
            <li class = "room-item clearfix">
                <h5 name = "room_type" id = "room_type">
                    <?php echo $hotelRoomType->roomTypeName(); ?>
                </h5>
                <!-- BEGIN .room-list-left -->
                <div class = "room-list-left">
                    <!--<img src="images/image_22.jpg" alt="" />-->
                    <?php if ($hotelRoomType->roomTypeImg() != "") { ?>
                        <a href = "#" class = "a_room_info" data-roomid = "<?php echo $hotelRoomType->roomTypeId(); ?>" data-dialog = "basic-modal-content<?php echo $hotelRoomType->roomTypeId(); ?>">
                            <img src = "<?php echo HTTP_PATH; ?>uploads/room/<?php echo $hotelRoomType->roomTypeImg(); ?>" />
                        </a>
                    <?php } else { ?>
                    <a href = "#" class = "a_room_info" data-roomid = "<?php echo $hotelRoomType->roomTypeId(); ?>" data-dialog = "basic-modal-content<?php echo $hotelRoomType->roomTypeId(); ?>">
                            <img src = "<?php echo HTTP_PATH; ?>bookings/images/test.jpg" />
                    </a>
                    <?php } ?>
                    <!--<a href = "#" class = "a_room_info" data-roomid = "<?php echo $hotelRoomType->roomTypeId(); ?>" data-dialog = "basic-modal-content<?php echo $hotelRoomType->roomTypeId(); ?>">Room Info</a>-->
                    <!-- END .room-list-left -->
                </div><!-- room-list-left -->

                <!-- BEGIN .room-list-right -->
                <div class = "room-list-right">
                    <div class = "room-meta">
                        <ul class = "booking-row">
                            <li style = "border-bottom: 1px dashed rgb(204, 204, 204); padding-bottom: 9px; width: 100%;">
                                <span>Price :</span>
                                <input type = "hidden" name = "numDays" value = "<?php echo $numDays; ?>" id = "numDays" />
                                    <span
                                        id = "priceTag<?php echo $hotelRoomType->roomTypeId(); ?>"><?php //echo $sessions->currSuffix();?></span>
                            </li>
                            <li>
                                <span class = "bed-type">Bed Types:</span>
                                <select class = "book-select-box"
                                        name = "room_bed_type<?php echo $hotelRoomType->roomTypeId(); ?>"
                                        id = "room_bed_type<?php echo $hotelRoomType->roomTypeId(); ?>"
                                        class = "medium-input-form-small"
                                        onchange = "getRoomRateOnBookings('<?php echo $hotelRoomType->roomTypeId(); ?>');
                                            getAvailableMeals(<?php echo $hotelRoomType->roomTypeId(); ?>, '<?php echo $_SESSION['check_in_date']; ?>', '<?php echo $_SESSION['check_out_date']; ?>', $('#room_bed_type<?php echo $hotelRoomType->roomTypeId(); ?> option:selected').val());"
                                        style = " font-size:11px;">
                                </select>
                                <script>
                                    getAvailableBeds(<?php echo $hotelRoomType->roomTypeId(); ?>, '<?php echo $_SESSION['check_in_date']; ?>', '<?php echo $_SESSION['check_out_date']; ?>');
                                </script>
                            </li>
                            <li>
                                <span class = "meal-type">Meal Types:</span>
                                <select name = "room_meal_type<?php echo $hotelRoomType->roomTypeId(); ?>"
                                        id = "room_meal_type<?php echo $hotelRoomType->roomTypeId(); ?>"
                                        class = "medium-input-form-small book-select-box"
                                        onchange = "getRoomRateOnBookings('<?php echo $hotelRoomType->roomTypeId(); ?>');"
                                        style = "font-size:11px;">
                                </select>
                            </li>
                            <li <?php if ($hotels->hotelAccommodationType() == $villa_type_id) { ?>   <?php } ?>   >
                                <!--INFO:style="display:none"-->
                                <span class = "no-rooms">No of Rooms:</span>
                                <?php
                                    if ($roomsCount > 0) {
                                        ?>
                                        <select name = "no_of_room<?php echo $hotelRoomType->roomTypeId(); ?>"
                                                id = "no_of_room<?php echo $hotelRoomType->roomTypeId(); ?>"
                                                class = "medium-input-h book-select-box" style = "margin-right:10px;"
                                                onchange = "getRoomRateOnBookings(<?php echo $hotelRoomType->roomTypeId(); ?>);">
                                            <?php
                                                for ($x = 1; $x <= $roomsCount; $x++) {
                                                    ?>
                                                    <option value = "<?php echo $x; ?>" <?php if ($x == 1) {
                                                        echo 'selected=selected';
                                                    } ?> ><?php echo $x; ?></option>
                                                <?php } ?>
                                        </select>
                                    <?php
                                    } else {
                                        ?>
                                        <span style = "color:red"><i>Not Available</i></span>
                                    <?php
                                    } ?>
                            </li>
                        </ul>
                    </div><!-- room-meta -->
                    <div class = "clearboth"></div>
                    <form class = "booking-form" name = "bookroom" />
                    <input type = "hidden" name = "room_type_id" value = "<?php echo $hotelRoomType->roomTypeId(); ?>"
                           id = "room_type_id" class = "room_types" />
                    <input class = "button2 bookbutton" type = "button" name = "booknow"
                           id = "booknow<?php echo $hotelRoomType->roomTypeId(); ?>"
                           onClick = "bookNow(<?php echo $hotelRoomType->roomTypeId(); ?>)" value = "Book Now"
                           style = "display:none" /></form><!-- END .room-list-right -->
                </div><!-- room-list-right -->
            </li>
            <!--repeated area end-->
        <?php } ?>
        </ul>
        </div>
    </div>

    <div class = "booking-side-wrapper">
        <div class = "booking-side clearfix">
            <h4 class = "title-style4">Your Reservation<span class = "title-block"></span></h4>
            <ul>
                <li>
                    <span>Dates: </span>
                    <?php //echo $_REQUEST['check_in_date'] . ' - ' . $_REQUEST['check_out_date'];
					//echo "<br /> // ***";
                        echo $_SESSION['check_in_date'] . ' - ' . $_SESSION['check_out_date']; ?>
                </li>
                <li style = "display:none;">
                    <span>Guests: </span>
                    <?php echo $_SESSION['book_room_adults'] . ' Adults, ' . $_SESSION['book_room_children'] . ' Children';
                        echo $_SESSION['book_room_adults'] . ' Adults, ' . $_SESSION['book_room_children'] . ' Children'; ?>
                </li>
            </ul>
            <a href = "<?php echo HTTP_PATH . 'bookings/' . $hotels->hotelSeoUrl() . '.html'; ?>" class = "bookbutton">Edit Reservation</a>
        </div>
    </div><!-- booking-side-wrapper -->
    <?php
        $offers=new Offers();
        $offerArr=$offers->getOffersForHotel($hotels_id);
        if(count($offerArr)>0){
    ?>
    <div class = "booking-side-wrapper">
        <div class = "booking-side clearfix">
            <h4 class = "title-style4">Special Offers<span class = "title-block"></span></h4>
            <div class="bookings-offers">
                <?php
                    foreach($offerArr as $offer){ ?>
                        <div class="offers">
                            <h4>
                                <?php
                                    $room=new HotelRoomType();
                                    $room->setRoomTypeId($offer['room_type']);
                                    $room->extractor($room->getHotelRoomTypeFromId());
                                    echo "Room: " . $room->roomTypeName() . " | ";
                                    echo $offer['title'];
                                    $room=null;
                                ?>
                            </h4>
                            <div  class="desc"><?php echo $offer['des']; ?></div>
                            <div class="offer-image clearfix">
                                <?php if ($offer['image'] != '' && file_exists(DOC_ROOT."uploads/special_offers/".$offer['image'])) { ?>
                                    <img style="max-width: 100%; max-height: 100%;" src="<?php echo HTTP_PATH ?>uploads/special_offers/<?php echo $offer['image'] ?>" />
                                <?php } ?>
                            </div>
                            <div class="clearfix detail">
                                <ul class="offerFe">
                                    <li>Offer type :
                                        <?php
                                            if($offer['dis_type']==0){
                                                echo 'Fixed Price';
                                            }elseif($offer['dis_type']==1){
                                                echo 'Percentage Discount';
                                            }elseif($offer['dis_type']==2){
                                                echo 'Free Nights';
                                            }elseif($offer['dis_type']==3){
                                                echo 'Custom';
                                            }
                                        ?>
                                    </li>
                                    <li><?php if($offer['date_validity']=='on'){echo 'Only for';}else{echo 'For';} ?> bookings between <?php echo $offer['from_date']; ?> & <?php echo $offer['to_date']; ?></li>
                                    <li>Offer available for
                                        <ul>
                                            <li>Beds:
                                                <?php
                                                    $beds=Libs::get('bed_type');
                                                    foreach(array_filter(explode(':',$offer['bed_type'])) as $bed){
                                                        echo $beds[$bed] . "/ ";
                                                    }
                                                ?>
                                            </li>
                                            <li>Meals:
                                                <?php
                                                    $meals=Libs::get('meal_type');
                                                    foreach(array_filter(explode(':',$offer['meal_type'])) as $meal){
                                                        echo $meals[$meal] . "/ ";
                                                    }
                                                ?>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </div><!-- booking-side-wrapper -->
    <?php } ?>
</div>

</div>
</div>
<div id = "footer">
    <div class="container"><span class="copy">&copy; 2014 Roomista.com | All rights reserved</span></div>
</div>
<!-- END body -->
</body>
</html>
<?php
    //$_SESSION['display_rate_in'] = "USD";
?>