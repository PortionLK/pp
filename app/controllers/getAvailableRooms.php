<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $hotels = new Hotels();
    $sessions = new Sessions();
    $hotelRoomRates = new HotelRoomRates();
    $hotelRoomType = new HotelRoomType();
    $roomcontrol = new RoomControl();
    $hotels_id = $_REQUEST['hotels_id'];
    $hotels->setHotelId($hotels_id);
    $hotels->extractor($hotels->getHotelFromId());
    $Sessions->setSearchSessions($_REQUEST['search_num_of_room'], $_REQUEST['search_adults'], $_REQUEST['search_children'], $_REQUEST['check_in_date'], $_REQUEST['check_out_date'], $_REQUEST['no_of_dates']);

    $day = 86400;
    $startTime = strtotime($_REQUEST['check_in_date']);
    $endTime = strtotime($_REQUEST['check_out_date']);
    $numDays = round(($endTime - $startTime) / $day);

    $room_count_empty = 0;
?>


<style>
    .rates_vertical {
        border: 1px #999 solid;
        border-radius: 4px;
    }

    .rates_vertical td {
        padding: 1px 3px;
        border: 0px;
        font-size: 9px !important;
        background-color: #eee;
        border-radius: 3px;
    }
</style>

<div class="hotel-check-rates-results-title" style="clear:both;"></div>
<div class="hotel-room-types-results-main-rows">
<?php
    $hotelRoomType->setRoomTypeHotelId($hotels_id);
    $getRoomType_row = $hotelRoomType->getHotelRoomTypeFromHotelsId();
    for ($k = 0; $k < count($getRoomType_row); $k++){
        $hotelRoomType->extractor($getRoomType_row, $k);
        $no_of_rooms = 0;
        $all_dates_available = true;

        $rc_in_date = $_REQUEST['check_in_date'];
        $rc_out_date = $_REQUEST['check_out_date'];

        $room_control = new RoomControl();
        $_temp = $room_control->getAllRoomDates($rc_in_date, $rc_out_date, $hotelRoomType->roomTypeId());

        $number_array = array();
        for ($i = 0; $i < count($_temp); $i++) {
            $room_control->extractor($_temp, $i);
            if ($room_control->rcNumOfRooms() == 0) {
                $all_dates_available = false;
            }
            //$no_of_rooms = $no_of_rooms + $room_control->rcNumOfRooms();
            array_push($number_array, $room_control->rcNumOfRooms());
        }
        sort($number_array);
        $no_of_rooms = $number_array[0];
        if (!$all_dates_available) {
            $no_of_rooms = 0;
        }
        $roomsCount = $no_of_rooms;
        /*if($hotelRoomType->roomTypeImg() !=''){
                  $countArry=0;
                 $temp_arr = array();
                 $temp_arr = explode(",",$hotels->roomTypeImg());
                 $countArry=count($temp_arr);
                 $possion=rand(0, $countArry-1);
                 $img_path=$temp_arr[$possion];
                } else {
                 $img_path="no-image.png";
                }*/

        $roomcontrol->setRcRoomTypeId($hotelRoomType->roomTypeId());

        $roomsCount=array();
        foreach (Common::createDateRangeArray($_REQUEST['check_in_date'], $_REQUEST['check_out_date']) as $key => $value) {
            $roomData = $roomcontrol->getAvailableRoomCountForRoomForDate($value,$hotelRoomType->roomTypeId());
            if(count($roomData)>0){
                if($roomData[0]['available_rooms']>0){
                    array_push($roomsCount, $roomData[0]['available_rooms']);
                }else{
                    array_push($roomsCount, 0);
                }
            }else{
                array_push($roomsCount, 0);
            }
        }

    if (count($roomsCount) > 0 && min($roomsCount)>0) {
            $room_count_empty++;
            $roomType = new HotelRoomType();
            $roomTypeData = $roomType->getHotelRoomTypeFromHotelRoomtypeId($hotelRoomType->roomTypeHotelId(), $hotelRoomType->roomTypeId());
            $roomType->extractor($roomTypeData);
            ?>
            <!--INFO: Modal Popup -->
            <div class="basic-modal-content" id="basic-modal-content<?php echo $hotelRoomType->roomTypeId(); ?>">
                <div class="content">
                    <div class="left-col">
                        <h4>Room Type: <?php echo $hotelRoomType->roomTypeName(); ?></h4>

                        <div class="left-col-upper">
                            <!-- Slider --><!--  Outer wrapper for presentation only, this can be anything you like -->
                            <div class="banner-fade" id="banner-fade-<?php echo $hotelRoomType->roomTypeId(); ?>">
                                <!-- start Basic Jquery Slider -->
                                <ul class="bjqs" id="bjqs-<?php echo $hotelRoomType->roomTypeId(); ?>">
                                    <?php if ($hotelRoomType->roomTypeImg() != "") { ?>
                                        <li>
                                            <img title="" src='<?php echo HTTP_PATH; ?>uploads/room/<?php echo $hotelRoomType->roomTypeImg(); ?>'/>
                                        </li>
                                    <?php
                                    }
                                        print("
                                            <script type='text/javascript'>
                                                loadRoomImagesForSlider('" . $hotelRoomType->roomTypeId() . "','bjqs-" . $hotelRoomType->roomTypeId() . "');
                                            </script>
                                        "); ?>
                                </ul>
                                <!-- end Basic jQuery Slider -->
                            </div>
                            <!-- End outer wrapper --><!-- //Slider -->
                        </div>
                        <div class="left-col-lower">
                            <ul>
                                <?php
                                    echo '<li><span class="text"> Max Persons: ' . $roomType->roomTypeMaxPersons() . '</span></li>';
                                    if ($roomType->roomTypeMaxExtraBeds() == 0) {
                                        echo '<li><span class="text">Extra beds are not available for this room.</span></li>';
                                    } else {
                                        echo '<li><span class="text">Max Extra Beds: ' . $roomType->roomTypeMaxExtraBeds() . '</span></li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="right-col">
                        <h4>Room Facilities</h4>

                        <div class="right-col-upper height1">
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
                        <div class="right-col-lower"></div>
                    </div>
                </div>
            </div>
            <!--INFO: Modal Popup// -->


            <div class="content-wrap set-border-bottom">
                <div class="tb-row">
                    <div class="sec-one set-min-height">
                        <a href="#" class="a_room_info" data-roomid="<?php echo $hotelRoomType->roomTypeId(); ?>" data-dialog="basic-modal-content<?php echo $hotelRoomType->roomTypeId(); ?>"><!--Room Info-->
                            <?php
                                $imgPath = DOC_ROOT . 'uploads/room/' . $hotelRoomType->roomTypeImg();
                                if (file_exists($imgPath) && $hotelRoomType->roomTypeImg() != '') {
                                    ?>
                                    <img style="width: 130px; height:86px;" src="<?php echo HTTP_PATH; ?>uploads/room/<?php echo $hotelRoomType->roomTypeImg(); ?>"/>
                                    <br/>
                                <?php } else { ?>
                                    <img style="width: 130px; height:86px;" src="<?php echo HTTP_PATH; ?>uploads/room/no_room_image.jpg"/>
                                    <br/>
                                <?php
                                }
                            ?>
                            <b><?php echo $hotelRoomType->roomTypeName(); ?></b> </a>
                    </div>
                    <div class="sec-two set-min-height">
                        <span id="priceTag<?php echo $hotelRoomType->roomTypeId(); ?>"></span>
                    </div>
                    <div class="sec-three set-min-height">
                        <input type="hidden" name="room_type_id" value="<?php echo $hotelRoomType->roomTypeId(); ?>" id="room_type_id" class="room_types"/>
                        <select name="room_bed_type<?php echo $hotelRoomType->roomTypeId(); ?>" id="room_bed_type<?php echo $hotelRoomType->roomTypeId(); ?>" class="medium-input-form-small room_bed_type" onchange="getAvailableMeals(<?php echo $hotelRoomType->roomTypeId(); ?>, '<?php echo $_REQUEST['check_in_date']; ?>', '<?php echo $_REQUEST['check_out_date']; ?>', $('#room_bed_type<?php echo $hotelRoomType->roomTypeId(); ?> option:selected').val()); getRoomRateOnBookings('<?php echo $hotelRoomType->roomTypeId(); ?>');" style=" font-size:11px;"> </select>
                        <script>
                            getAvailableBeds(<?php echo $hotelRoomType->roomTypeId(); ?>, '<?php echo $_REQUEST['check_in_date']; ?>', '<?php echo $_REQUEST['check_out_date']; ?>');
                        </script>
                    </div>
                    <div class="sec-four set-min-height">
                        <select name="room_meal_type<?php echo $hotelRoomType->roomTypeId(); ?>" id="room_meal_type<?php echo $hotelRoomType->roomTypeId(); ?>" class="medium-input-form-small" onchange="getRoomRateOnBookings('<?php echo $hotelRoomType->roomTypeId(); ?>');" style="font-size:11px;"> </select>
                    </div>
                    <div class="sec-six set-min-height">
                        <select name="no_of_room<?php echo $hotelRoomType->roomTypeId(); ?>" id="no_of_room<?php echo $hotelRoomType->roomTypeId(); ?>" class="medium-input-h" style="margin-right:10px;" onchange="getRoomRateOnBookings(<?php echo $hotelRoomType->roomTypeId(); ?>);">
                            <?php
                                if ($all_dates_available) {
                                    for ($x = 1; $x <= min($roomsCount); $x++) {
                                        ?>
                                        <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <option value="0">0</option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="sec-five set-min-height">
                        <?php if ($all_dates_available) { ?>
                            <a id="booknow<?php echo $hotelRoomType->roomTypeId(); ?>" href="#" data-roomid="<?php echo $hotelRoomType->roomTypeId(); ?>" onclick="makePaymentButton(<?php echo $hotelRoomType->roomTypeId(); ?>);" class=" show-price ">Book Now</a>
                        <?php } ?>
                    </div>
                </div>
                <?php
                    print("
                        <script type='text/javascript'>
                            getRoomRateOnBookings(" . $hotelRoomType->roomTypeId() . ");
                        </script>
                        ");
                ?>
            </div>
            <div class="clearfix"></div> 
        <?php
        } else {
        //$room_count_empty = 1;
        }
    } ?>
    <?php if ($room_count_empty == 0) { ?>
        <div align="center" style="border:double;border-color:#06C;">
            <span style="color:#d81a1a;"> - Rooms not available - </span><br/>
            <span style="color:#4A8ED0;">Contact us for the best rates available !</span>
            <span style="color:#2C4870;font-weight:bold;">Call Now-011 434 7444</span>
        </div>
    <?php } ?>


    <input type="hidden" value="<?php echo $hotels_id; ?>" id="hotel_id"/>
    <input type="hidden" value="<?php echo $numDays; ?>" id="numDays"/>

</div>
</div>