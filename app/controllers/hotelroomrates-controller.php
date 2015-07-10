<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];
    $post_action = $_REQUEST['action'];

    switch ($post_action) {

        case "getBookingRoomRates":
            getBookingRoomRates();
            break;
        case "getBookingRoomRatesOnBookings":
            getBookingRoomRatesOnBookings();
            break;
        case "getAvailableDropdown":
            getAvailableDropdown();
            break;
        case "getAvailableBeds":
            getAvailableBeds();
            break;
        case "getAvailableMeals":
            getAvailableMeals();
            break;

    }


    switch ($action) {

        case "viewCategory":
            viewCategory();
            break;
        case "addHotelRoomRates":
            addHotelRoomRates();
            break;
        case "addHotelRoomRatesNew":
            addHotelRoomRatesNew();
            break;
        case "editHotelRates":
            editHotelRates();
            break;
        case "deleteCategory":
            deleteCategory();
            break;
        case "getHotelRoomRates":
            getHotelRoomRates();
            break;
        case "makePaymentButton":
            makePaymentButton();
            break;
        case "ratesDeleteById":
            ratesDeleteById();
            break;
    }

    function getAvailableBeds()
    {
        $beds_arr = array();
        $bed_array = Libs::get("bed_type");
        $meal_array = Libs::get("meal_type");
        $beds = array();
        $bed_available = false;
        $zeroRateDetected = false;
        $rate = 0;
        $room_rate = 0;
        $roomTypeId = $_REQUEST['roomTypeId'];
        $from_date = $_REQUEST['from_date'];
        $to_date = $_REQUEST['to_date'];

        foreach ($bed_array as $keyBed => $bed) {
            foreach ($meal_array as $keyMeal => $meal) {
                $hotelRoomRates = new HotelRoomRates();
                $hotelRoomRates->setHotelRoomTypeId($roomTypeId);
                //$hotelRoomRates->setDateIn($from_date);
                //$hotelRoomRates->setDateOut($to_date);
                //$room_rate = $hotelRoomRates->getRateInRoomTypeForDates($keyBed, $keyMeal);

                foreach (Common::createDateRangeArray($from_date, date("Y-m-d", strtotime("-1 days", strtotime($to_date)))) as $key => $value) {
                    $rate = $hotelRoomRates->getRateInRoomTypeForDate($keyBed, $keyMeal, $value);
                    if ($rate > 0) {
                        $room_rate = $room_rate + $rate;
                        $zeroRateDetected = false;
                    } else {
                        $zeroRateDetected = true;
                    }
                }
                if ($zeroRateDetected == false && $room_rate <> 0) {
                    $bed_available = true;
                    break;
                } else {
                    $bed_available = false;
                }
            }
            if ($bed_available) {
                $beds[] = array("key" => $keyBed, "value" => $bed);
                //$beds[$keyBed] = $bed;
            }
            $zeroRateDetected = false;
        }

        $beds_arr = array("beds" => $beds);
        echo json_encode($beds_arr);
    }

    function getAvailableMeals()
    {

        $bed_type = $_REQUEST['bed_type'];
        $meal_array = Libs::get("meal_type");
        $meals = array();
        $zeroRateDetected = false;
        $rate = 0;
        $room_rate = 0;
        $roomTypeId = $_REQUEST['roomTypeId'];
        $from_date = $_REQUEST['from_date'];
        $to_date = $_REQUEST['to_date'];

        foreach ($meal_array as $keyMeal => $meal) {
            $hotelRoomRates = new HotelRoomRates();
            $hotelRoomRates->setHotelRoomTypeId($roomTypeId);
            //$hotelRoomRates->setDateIn($from_date);
            //$hotelRoomRates->setDateOut($to_date);
            //$room_rate = $hotelRoomRates->getRateInRoomTypeForDates($bed_type, $keyMeal);

            foreach (Common::createDateRangeArray($from_date, date("Y-m-d", strtotime("-1 days", strtotime($to_date)))) as $key => $value) {
                $rate = $hotelRoomRates->getRateInRoomTypeForDate($bed_type, $keyMeal, $value);
                if ($rate > 0) {
                    $room_rate = $room_rate + $rate;
                    //$zeroRateDetected = false;
                } else {
                    $zeroRateDetected = true;
                }
            }

            if ($zeroRateDetected == false && $room_rate <> 0) {
                $meals[] = array("key" => $keyMeal, "value" => $meal);
                //$meals[$keyMeal] =  $meal;
            }
            $zeroRateDetected = false;
        }

        $retun_arr = array("meals" => $meals);
        echo json_encode($retun_arr);
    }

    function getAvailableDropdown()
    {

        $bed_array = array("sgl", "dbl", "tpl");
        $meal_array = array("ro", "bb", "hb", "fb");
        $bed_string = "";
        $meal_string = "";

        $roomTypeId = $_REQUEST['roomTypeId'];
        $display_rate_in = $_SESSION['display_rate_in']; // 'USD';

        for ($x = 0; $x < count($bed_array); $x++) {
            for ($y = 0; $y < count($meal_array); $y++) {

                $room_bed_type = $bed_array[$x];
                $room_meal_type = $meal_array[$y];

                $_SESSION['display_rate_in'] = $display_rate_in;
                // number of days
                $day = 86400;
                $startTime = strtotime($_SESSION['check_in_date']);
                $endTime = strtotime($_SESSION['check_out_date']);
                $numDays = round(($endTime - $startTime) / $day);

                $hotelRoomRates = new HotelRoomRates();
                $hotelRoomRates->setHotelRoomTypeId($roomTypeId);
                $room_rate = $hotelRoomRates->getRateInRoomType($room_bed_type, $room_meal_type);

                if ($room_rate == 0) {
                    $bed_string[] = $room_bed_type;
                    $meal_string[] = $room_meal_type;
                }
            }
        }

        $final_array = '';
        foreach ($meal_string as $a) {
            $final_array .= $a . ',';
        }

        $retun_arr = array("final_array" => $final_array);
        echo json_encode($retun_arr);
    }

    function ratesDeleteById()
    {
        $rates = new HotelRoomRates();
        $rates->setRoomRateId($_REQUEST['id']);
        //INFO: Log
        //$temp_room_rate = new HotelRoomRates();
        //$temp_room_rate->setRoomRateId($_REQUEST['id']);
        //$temp_room_rate=(array)$temp_room_rate->getRateFromId();
        //INFO: Log
        if ($rates->ratesDeleteById()) {
            //INFO: Log
            //$TransactionLog=new TransactionLog($temp_room_rate[0]['hotel_id'],Libs::getKey('hotel_sections','Hotel Rates - Delete'),'Delete',Sessions::getMemberId(),'room_rates',$temp_room_rate[0],'');
            //$TransactionLog->log();
            //INFO: Log//
            Common::jsonSuccess("Room Rates Delete Successfully!");
        } else {
            Common::jsonError("Error");
        }
        //INFO: Log
        //$temp_room_rate=null;
        //INFO: Log//
    }

    function viewCategory()
    {
        $category = new Category();
        $data = $category->getAllCategoryPaginated($_REQUEST['page']);

        $count = $category->getAllCategoryCount();

        viewTable($data, $count[0]['count']);

    }

    function getHotelRoomRates()
    {
        $hotelRoomRates = new HotelRoomRates();
        $hotelRoomRates->setHotelRoomTypeId($_REQUEST['roomTypeId']);
        $hotelRoomRates->checkRateInRoomType($_REQUEST['room_bed_type'], $_REQUEST['room_meal_type'], $_REQUEST['room_count'], $_REQUEST['from_date'], $_REQUEST['to_date']);

        //$data = $category->getAllCategoryPaginated($_REQUEST['page']);

        //$count = $category->getAllCategoryCount();
    }

    function getBookingRoomRates()
    {
        $hotelRoomRates = new HotelRoomRates();
        $hotelRoomRates->setHotelRoomTypeId($_REQUEST['roomTypeId']);
        $hotelRoomRates->checkRateInRoomType($_REQUEST['room_bed_type'], $_REQUEST['room_meal_type'], $_REQUEST['room_count'], $_REQUEST['from_date'], $_REQUEST['to_date']);

        //$data = $category->getAllCategoryPaginated($_REQUEST['page']);

        //$count = $category->getAllCategoryCount();
    }

    function makePaymentButton()
    {
        $hotelRoomRates = new HotelRoomRates();
        $hotelRoomRates->setHotelRoomTypeId($_REQUEST['roomTypeId']);
        $rate = $hotelRoomRates->checkRateInRoomTypeOnlinePay($_REQUEST['room_bed_type'], $_REQUEST['room_meal_type'], $_REQUEST['room_count'], $_REQUEST['check_in'], $_REQUEST['check_out']);

        if ($rate > 0) {
            if ($_SESSION['display_rate_in'] == 'LKR') {
                $rate = Common::currencyConvert("USD", "LKR", $rate);
            }
            Sessions::setOnlinePaymentData($_REQUEST['room_bed_type'], $_REQUEST['room_meal_type'], $_REQUEST['room_count'], $rate, $_REQUEST['check_in'], $_REQUEST['check_out'], $_REQUEST['roomTypeId'], $_REQUEST['hotels_id']);
            echo(1);
        } else {
            echo(0);
        }
    }


    //INFO: Change to save room rates
    function addHotelRoomRatesNew()
    {
        try {
            $roomrates = new HotelRoomRates();
            $roomrates->setValues($_REQUEST);

            $exRateRecord = $roomrates->getAllRatesForDates($roomrates->dateIn(), $roomrates->dateOut(), $roomrates->hotelRoomTypeId());

            $exRateRecord1="";
            $exRateRecord2="";
            $arraySplit = array();
            $room_rate_ids = array();
            $allDatesArray2 = array();
            $i = 1;
            $l = 1;

            foreach ($exRateRecord as $key => $row) {
                $in_date = $row['date_in'];
                $out_date = $row['date_out'];
                $exRoomControlArr[$i] = $row;

                $strstartdate = strtotime($in_date);
                $strenddate = strtotime($out_date);
                $dayDiff = ($strenddate - $strstartdate) / 86400;
                $j = 0;
                while ($j <= $dayDiff) {
                    $nextDay = $strstartdate + ($j * 86400);
                    $allDatesArray2[$l] = $nextDay;
                    $j++;
                    $l++;
                }
                $room_rate_ids[$i] = $row['room_rate_id'];
                $i++;
            }
            if ($allDatesArray2 != "") {
                $sizeOfADA = sizeof($allDatesArray2);
                $strOfInputStart = strtotime($roomrates->dateIn());
                $strOfRangeStart = $allDatesArray2[1];
                $strOfInputEnd = strtotime($roomrates->dateOut());
                $strOfRangeEnd = $allDatesArray2[$sizeOfADA];

                $m = 1;
                $n = 1;
                $o = 1;

                if ($strOfInputStart < $strOfRangeStart) {
                    $differenceOf = ($strOfRangeStart - $strOfInputStart) / 86400;
                    $x = 0;
                    $start = $strOfInputStart;
                    while ($x < $differenceOf) {
                        $nxday = $start + ($x * 86400);
                        array_push($allDatesArray2, $nxday);
                        $x++;
                    }
                    if ($strOfInputEnd > $strOfRangeEnd) {
                        $y = 1;
                        $differenceOfB = ($strOfInputEnd - $strOfRangeEnd) / 86400;
                        while ($y <= $differenceOfB) {
                            $nxday2 = $strOfRangeEnd + ($y * 86400);
                            array_push($allDatesArray2, $nxday2);
                            $y++;
                        }
                    }
                    array_multisort($allDatesArray2);
                    $arraySplit = splitArray($allDatesArray2, $m, $n, $o, $strOfInputStart, $strOfInputEnd);

                    $roomrates->ratesDeleteByRateId($room_rate_ids);
                    if(!addHotelRoomRates($roomrates)){
                        throw new Exception("Error"); new Exception("Error");
                    }
                    if (array_key_exists(3, $arraySplit)) {
                        $szOfArray = sizeof($arraySplit[3]);
                        $fDate = date("Y-m-d", $arraySplit[3][1]);
                        $tDate = date("Y-m-d", $arraySplit[3][$szOfArray]);

                        $exRateRecord2 = $row;
                        $exRateRecord2['date_in'] = $fDate;
                        $exRateRecord2['date_out'] = $tDate;
                        if(!addHotelRoomRates($exRateRecord2)){
                            throw new Exception("Error");
                        }
                    }
                } else {
                    if ($strOfInputEnd > $strOfRangeEnd) {
                        $y = 1;
                        $differenceOfB = ($strOfInputEnd - $strOfRangeEnd) / 86400;
                        while ($y <= $differenceOfB) {
                            $nxday2 = $strOfRangeEnd + ($y * 86400);
                            array_push($allDatesArray2, $nxday2);
                            $y++;
                        }
                    }
                    array_multisort($allDatesArray2);

                    $arraySplit = splitArray($allDatesArray2, $m, $n, $o, $strOfInputStart, $strOfInputEnd);
                    if(!$roomrates->ratesDeleteByRateId($room_rate_ids)){
                        throw new Exception("Error");
                    }
                    if (array_key_exists(1, $arraySplit)) {
                        $szOfArray = sizeof($arraySplit[1]);
                        $fDate = date("Y-m-d", $arraySplit[1][1]);
                        $tDate = date("Y-m-d", $arraySplit[1][$szOfArray]);

                        $exRateRecord1 = $row;
                        $exRateRecord1['date_in'] = $fDate;
                        $exRateRecord1['date_out'] = $tDate;
                        if(!addHotelRoomRates($exRateRecord1)){
                            throw new Exception("Error");
                        }
                        if(!addHotelRoomRates($roomrates)){
                            throw new Exception("Error");
                        }
                        if (array_key_exists(3, $arraySplit)) {
                            $szOfArray = sizeof($arraySplit[3]);
                            $fDate = date("Y-m-d", $arraySplit[3][1]);
                            $tDate = date("Y-m-d", $arraySplit[3][$szOfArray]);

                            $exRateRecord2 = $row;
                            $exRateRecord2['date_in'] = $fDate;
                            $exRateRecord2['date_out'] = $tDate;
                            if(!addHotelRoomRates($exRateRecord2)){
                                throw new Exception("Error");
                            }
                        }
                    } else {
                        $arraySplit = splitArray($allDatesArray2, $m, $n, $o, $strOfInputStart, $strOfInputEnd);
                        if(!$roomrates->ratesDeleteByRateId($room_rate_ids)){
                            throw new Exception("Error");
                        }
                        if(!addHotelRoomRates($roomrates)){
                            throw new Exception("Error");
                        }
                        if (array_key_exists(3, $arraySplit)) {
                            $szOfArray = sizeof($arraySplit[3]);
                            $fDate = date("Y-m-d", $arraySplit[3][1]);
                            $tDate = date("Y-m-d", $arraySplit[3][$szOfArray]);

                            $exRateRecord2 = $row;
                            $exRateRecord2['date_in'] = $fDate;
                            $exRateRecord2['date_out'] = $tDate;
                            if(!addHotelRoomRates($exRateRecord2)){
                                throw new Exception("Error");
                            }
                        }
                    }
                }
            } else {
                if(!addHotelRoomRates($roomrates)){
                    throw new Exception("Error");
                }
            }

            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('6');
            Common::jsonSuccess("Room Rates Added Successfully!");
        } catch (Exception $ex) {
            Common::jsonError("Error");
        }
    }

    function splitArray($allDatesArray2, $m, $n, $o, $strOfInputStart, $strOfInputEnd)
    {
        foreach ($allDatesArray2 as $key => $val) {
            if ($val < $strOfInputStart) {
                $arraySplit[1][$m] = $val;
                $m++;
            } else if (($val >= $strOfInputStart) && ($val <= $strOfInputEnd)) {
                $arraySplit[2][$n] = $val;
                $n++;
            } else {
                $arraySplit[3][$o] = $val;
                $o++;
            }
        }

        return $arraySplit;
    }

    function addHotelRoomRates($_roomrates)
    {
        $roomrates = new HotelRoomRates();
        $roomrates->setValues($_roomrates);

        $localCols = $roomrates->getRateFields('Local');
        $foreignCols = $roomrates->getRateFields('Foreign');

        //INFO: Assumes that `count($foreignCols)`==`count($localCols)`.
        for ($i = 1; $i < count($foreignCols); $i = $i + 2) {
            $val_array_foreign[] = ($roomrates->getFieldValue($foreignCols[$i]) - $roomrates->getFieldValue($foreignCols[$i - 1])) / 100;
            $val_array_local[] = ($roomrates->getFieldValue($localCols[$i]) - $roomrates->getFieldValue($localCols[$i - 1])) / 100;
        }

        $max_foreign = max($val_array_foreign);
        $max_local = max($val_array_local);
        $min_foreign = min($val_array_foreign);
        $min_local = min($val_array_local);

        $roomrates->setDiscountRatesUpForiegn($max_foreign);
        $roomrates->setDiscountRatesUpLocal($max_local);
        $roomrates->setHotelPriceMinForiegn($min_foreign);
        $roomrates->setHotelPriceMinLocal($min_local);
        $roomrates->setModifiedDate(date('Y-m-d'));

        return $roomrates->newHotelRoomRate();

        //if ($roomrates->newHotelRoomRate()) {
            //INFO: Replaced following commented section with above  `$foreignCols` thing. As no need to re-load data and do the calculation.
            /*// update max and min
            $roomrates = new HotelRoomRates();
            $roomrates->setRoomRateId(mysql_insert_id());
            $query_data = $roomrates->getRateFromId();
            $ic = 0;
            foreach ($query_data as $x) {
                foreach ($x as $key => $val) {
                    if ($ic > 7 && $ic < 67) {
                        $ARRAY[$ic] = $val;
                    }
                    $ic++;
                }
            }
            for ($x = 67; $x > 7; $x--) {
                $y = ($x - 1);
                if ($x < 36) {
                    $val_array_local[] = (($ARRAY[$x] - $ARRAY[$y]) / 100);
                } else {
                    $val_array_foreign[] = (($ARRAY[$x] - $ARRAY[$y]) / 100);
                }
            }
            $max_foreign = max($val_array_foreign);
            $max_local = max($val_array_local);
            $min_foreign = min($val_array_foreign);
            $min_local = min($val_array_local);
            $roomrates->setDiscountRatesUpForiegn($max_foreign);
            $roomrates->setDiscountRatesUpLocal($max_local);
            $roomrates->setHotelPriceMinForiegn($min_foreign);
            $roomrates->setHotelPriceMinLocal($min_local);
            $roomrates->updateHotelRoomRateMax();*/

            //INFO: Log
            //$temp_rate = $_REQUEST;
            //$temp_rate['discount_rates_up_foriegn']=$max_foreign;
            //$temp_rate['discount_rates_up_local']=$max_local;
            //$temp_rate['hotel_price_min_foriegn']=$min_foreign;
            //$temp_rate['hotel_price_min_local']=$min_local;
            //$TransactionLog=new TransactionLog($temp_rate['hotel_id'],Libs::getKey('hotel_sections','Hotel Rates - Add'),'Insert',Sessions::getMemberId(),'room_rates',$temp_rate,'');
            //$TransactionLog->log();
            //$temp_rate=null;
            //INFO: Log//

            //max and min

            //Common::jsonSuccess("Room Rates Added Successfully!");
        //} else {
            //Common::jsonError("Error");
        //}

    }

    function editHotelRates()
    {
        $roomrates = new HotelRoomRates();
        $roomrates->setValues($_REQUEST);

        $localCols = $roomrates->getRateFields('Local');
        $foreignCols = $roomrates->getRateFields('Foreign');

        //INFO: Assumes that `count($foreignCols)` and `count($localCols)` are same.
        for ($i = 1; $i < count($foreignCols); $i = $i + 2) {
            $val_array_foreign[] = ($roomrates->getFieldValue($foreignCols[$i]) - $roomrates->getFieldValue($foreignCols[$i - 1])) / 100;
            $val_array_local[] = ($roomrates->getFieldValue($localCols[$i]) - $roomrates->getFieldValue($localCols[$i - 1])) / 100;
        }

        $max_foreign = max($val_array_foreign);
        $max_local = max($val_array_local);
        $min_foreign = min($val_array_foreign);
        $min_local = min($val_array_local);

        $roomrates->setDiscountRatesUpForiegn($max_foreign);
        $roomrates->setDiscountRatesUpLocal($max_local);
        $roomrates->setHotelPriceMinForiegn($min_foreign);
        $roomrates->setHotelPriceMinLocal($min_local);
        $roomrates->setModifiedDate(date('Y-m-d'));

        //INFO: Log
        /*$temp_rate1 = new HotelRoomRates();
        $temp_rate2 = $_REQUEST;
        $temp_rate1->setRoomRateId($temp_rate2['room_rate_id']);
        $temp_rate1=(array)$temp_rate1->getRatesFromRateId();*/
        //INFO: Log//

        if ($roomrates->updateHotelRoomRate()) {
            //INFO: Replaced following commented section with above  `$foreignCols` thing. As no need to re-load data and do the calculation.
            /*// update max and min
            $roomrates = new HotelRoomRates();
            $roomrates->setRoomRateId($_REQUEST['room_rate_id']);
            $query_data = $roomrates->getRateFromId();
            $ic = 0;
            foreach ($query_data as $x) {
                foreach ($x as $key => $val) {
                    if ($ic > 7 && $ic < 67) {
                        $ARRAY[$ic] = $val;
                    }
                    $ic++;
                }
            }
            for ($x = 67; $x > 7; $x--) {
                $y = ($x - 1);
                if ($x < 36) {
                    $val_array_local[] = (($ARRAY[$x] - $ARRAY[$y]) / 100);
                } else {
                    $val_array_foreign[] = (($ARRAY[$x] - $ARRAY[$y]) / 100);
                }
            }
            $max_foreign = max($val_array_foreign);
            $max_local = max($val_array_local);
            $min_foreign = min($val_array_foreign);
            $min_local = min($val_array_local);
            $roomrates->setDiscountRatesUpForiegn($max_foreign);
            $roomrates->setDiscountRatesUpLocal($max_local);
            $roomrates->setHotelPriceMinForiegn($min_foreign);
            $roomrates->setHotelPriceMinLocal($min_local);
            $roomrates->updateHotelRoomRateMax();*/

            //INFO: Log
            //$temp_rate2['discount_rates_up_foriegn']=$max_foreign;
            //$temp_rate2['discount_rates_up_local']=$max_local;
            //$temp_rate2['hotel_price_min_foriegn']=$min_foreign;
            //$temp_rate2['hotel_price_min_local']=$min_local;
            //$TransactionLog=new TransactionLog($temp_rate2['hotel_id'],Libs::getKey('hotel_sections','Hotel Rates - Edit'),'Update',Sessions::getMemberId(),'room_rates',$temp_rate1[0],$temp_rate2);
            //$TransactionLog->log();

            //$temp_hotel1=null;
            //$temp_hotel2=null;
            //INFO: Log

            //max and min
            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('6');
            //echo($_REQUEST['hotel_step_id']);
            Common::jsonSuccess("Room Rates Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateCategory()
    {

        $admin = new Category();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $admin->setValues($get_edited);

        if ($admin->updateCategory()) {
            Common::jsonSuccess("Category Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteCategory()
    {

        $category = new Category();
        $category->setCategoryId($_REQUEST['id']);

        if ($category->deleteCategory()) {
            Common::jsonSuccess("Category Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $category = new Category();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewCategory");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>

        <div class="mws-panel-header"><span class="mws-i-24 i-table-1">View Category</span></div>
        <div class="mws-panel-body">
            <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
                <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Category Seo Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($data) > 0) { ?>
                    <?php
                    for ($i = 0; $i < count($data); $i++) {
                        $category->extractor($data, $i);
                        ?>
                        <tr id="row_<?php echo $category->categoryId(); ?>">
                            <td><?php echo $category->categoryName(); ?></td>
                            <td><?php echo $category->categorySeoName(); ?></td>
                            <td class="center">
                                <a onclick="loadGUIContent('category','edit','<?php echo $category->categoryId(); ?>')">Edit</a>
                                <a href="javascript:;" onclick="deleteCategory(<?php echo $category->categoryId(); ?>)" class="toggle">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php

        $paginations->drawPagination();

    }

    function getBookingRoomRatesOnBookings()
    {
        $total = 0;
        $total_lkr = 0;
        $price_tag = 0;
        $room_rate = 0;
        $rate = 0;
        $zeroRateDetected = false;
        $roomTypeId = $_REQUEST['roomTypeId'];
        $room_bed_type = $_REQUEST['room_bed_type'];
        $room_meal_type = $_REQUEST['room_meal_type'];
        $room_count = $_REQUEST['room_count'];
        $display_rate_in = $_REQUEST['display_rate_in'];

        $_SESSION['display_rate_in'] = $display_rate_in;

        $day = 86400;
        $startTime = strtotime($_SESSION['check_in_date']);
        $endTime = strtotime($_SESSION['check_out_date']);
        $numDays = round(($endTime - $startTime) / $day);

        $hotelRoomRates = new HotelRoomRates();
        $hotelRoomRates->setHotelRoomTypeId($roomTypeId);
        //$room_rate = $hotelRoomRates->getRateInRoomType($room_bed_type, $room_meal_type);
        foreach (Common::createDateRangeArray($_SESSION['check_in_date'], date("Y-m-d", strtotime("-1 days", strtotime($_SESSION['check_out_date'])))) as $key => $value) {
            $rate = $hotelRoomRates->getRateInRoomTypeForDate($room_bed_type, $room_meal_type, $value);
            if ($rate > 0) {
                $room_rate = $room_rate + $rate;
            } else {
                $zeroRateDetected = true;
            }
        }


        if ($zeroRateDetected == false && $room_rate > 0) {
            //if ($room_rate > 0) {
            // replace LKR with current currency session
            if ($display_rate_in == "LKR") {
                $converted_rate = Common::currencyConvert("USD", $display_rate_in, $room_rate);
            } else {
                $converted_rate = $room_rate;
            }
            $total = $room_rate * $room_count; // * $numDays;
            $total_lkr = $converted_rate * $room_count; // * $numDays;
        } else {
            $total = 0;
            $total_lkr = 0;
        }
        if ($display_rate_in == "LKR") {
            Sessions::setOnlinePaymentRateWithCurrency($total_lkr, $display_rate_in);
            $price_tag = number_format($total_lkr, 2) . " " . $display_rate_in;
        } else {
            Sessions::setOnlinePaymentRateWithCurrency($total, $display_rate_in);
            $price_tag = number_format($total, 2) . " " . $display_rate_in;
        }

        $_final = array("total" => number_format($total, 2), "total_lkr" => $total_lkr, "display_rate_in" => $display_rate_in, //"price_tag" => number_format($total, 2) . " " . $display_rate_in
            "price_tag" => $price_tag);
        echo json_encode($_final);
    }

?>