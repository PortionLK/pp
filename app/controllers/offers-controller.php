<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "view":
            view();
            break;
        case "insert":
            insert();
            break;
        case "update":
            update();
            break;
        case "delete":
            delete();
            break;
        case "getRoomTypes":
            getRoomTypes();
            break;
        case "getBedTypes":
            getBedTypes();
            break;
        case "getMealTypes":
            getMealTypes();
            break;
        case "updateRoomTypes":
            updateRoomTypes();
            break;
        case "updateBedTypes":
            updateBedTypes();
            break;
        case "updateMealTypes":
            updateMealTypes();
            break;
        case "removeOfferImage":
            removeOfferImage();
            break;
        case "validOffers":
            validOffers();
            break;
        case "loadOffersForHotel":
            loadOffersForHotel();
            break;
    }

    function updateRoomTypes()
    {

        $room = new Rooms();
        $room->setVillaId($_REQUEST['hotell_id']);
        $room_list = $room->getAllRoomTypesEnable();

        if (empty($room_list)) {
            echo "No Room Types";
        } else {

            for ($x = 0; $x < count($room_list); $x++) {
                $room->extractor($room_list, $x);
                $room_arr = explode(':', $_REQUEST['x_roomType']);
                ?>
                <input type="checkbox"  <?php if ($x == 0) {
                    echo "id='edit_room_type'";
                } ?>  name="edit_room_type" value="<?php echo($room->id()); ?>"
                       class="room_type send_group send_data" <?php if (in_array($room->id(), $room_arr)) {
                    echo('checked="checked"');
                } ?> /> <?php echo($room->name());

            }
        }
    }

    function updateBedTypes()
    {

        $beds = new Beds();
        $beds->setVillaId($_REQUEST['hotell_id']);
        $beds_list = $beds->getAllBedTypes();

        if (empty($beds_list)) {
            echo "No Bed Types";
        } else {

            for ($x = 0; $x < count($beds_list); $x++) {
                $beds->extractor($beds_list, $x);
                $bed_arr = explode(':', $_REQUEST['x_bedType']);
                ?>
                <input type="checkbox"  <?php if ($x == 0) {
                    echo "id='edit_bed_type'";
                } ?>  name="edit_bed_type" value="<?php echo($beds->id()); ?>"
                       class="bed_type send_group send_data" <?php if (in_array($beds->id(), $bed_arr)) {
                    echo('checked="checked"');
                } ?> /> <?php echo($beds->name());

            }
        }

    }

    function updateMealTypes()
    {
        $meal = new Meals();
        $meal->setVillaId($_REQUEST['hotell_id']);
        $meal_list = $meal->getAllMealTypes();

        if (empty($meal_list)) {
            echo "No Meal Types";
        } else {

            for ($x = 0; $x < count($meal_list); $x++) {
                $meal->extractor($meal_list, $x);
                $meal_arr = explode(':', $_REQUEST['x_mealType']);
                ?>
                <input type="checkbox"  <?php if ($x == 0) {
                    echo "id='edit_meal_type'";
                } ?>  name="edit_meal_type" value="<?php echo($meal->id()); ?>"
                       class="meal_type send_group send_data" <?php if (in_array($meal->id(), $meal_arr)) {
                    echo('checked="checked"');
                } ?> /> <?php echo($meal->name());

            }
        }
    }

    function getRoomTypes()
    {

        $rooms = new Rooms();
        $rooms->setVillaId($_REQUEST['hotell_id']);
        $roomList = $rooms->getAllRoomTypesEnable();
        if (empty($roomList)) {
            echo "Add Room Types";
        } else {
            for ($x = 0; $x < count($roomList); $x++) {
                $rooms->extractor($roomList, $x);
                ?>
                <input type="checkbox" <?php if ($x == 0) {
                    echo "id='room_type'";
                } ?> name="room_type" value="<?php echo($rooms->id()); ?>" class="room_type send_group send_data"/>
                <?php
                echo($rooms->name());
            }
        }

    }

    function getBedTypes()
    {

        $beds = new Beds();
        $beds->setVillaId($_REQUEST['hotell_id']);
        $beds_list = $beds->getAllBedTypes();

        if (empty($beds_list)) {
            echo "Add Bed Types";
        } else {

            for ($b = 0; $b < count($beds_list); $b++) {
                $beds->extractor($beds_list, $b);
                ?>
                <input type="checkbox" <?php if ($b == 0) {
                    echo "id='bed_type'";
                } ?> name="bed_type" value="<?php echo($beds->id()); ?>" class="bed_type send_group send_data"/>
                <?php
                echo($beds->name());
            }
        }
    }

    function getMealTypes()
    {

        $meal = new Meals();
        $meal->setVillaId($_REQUEST['hotell_id']);
        $meal_list = $meal->getAllMealTypes();

        if (empty($meal_list)) {
            echo "Add Meal Types";
        } else {

            for ($m = 0; $m < count($meal_list); $m++) {
                $meal->extractor($meal_list, $m);
                ?>
                <input type="checkbox" <?php if ($m == 0) {
                    echo "id='meal_type'";
                } ?> name="meal_type" value="<?php echo($meal->id()); ?>" class="meal_type send_group send_data"/>
                <?php
                echo($meal->name());
            }
        }

    }

    function view()
    {

        $offers = new Offers();
        $data = $offers->selectAllPaginated($_REQUEST['page']);
        $count = $offers->selectAllCount();

        viewTable($data, $count[0]['count']);

    }

    function insert()
    {
        //print_r($_REQUEST);

        $offers = new Offers();
        $_REQUEST['image'] = Sessions::getUploadedOfferImage();
        $offers->setValues($_REQUEST);
        Debug::log($offers->bedType());
        $offers->setFromDate(date('Y-m-d', strtotime($_REQUEST['from_date'])));
        $offers->setToDate(date('Y-m-d', strtotime($_REQUEST['to_date'])));

        if ($offers->insert()) {
            //Sessions::setTourBannerId(mysql_insert_id());
            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('9');
            Common::jsonSuccess("Offer Added Successfully!");
            Sessions::setUploadedDestinationLogo('');
        } else {
            Common::jsonError("Error");
        }

    }

    function update()
    {
        $offers = new Offers();
        $get_edited = array();

        $_REQUEST['image'] = Sessions::getUploadedOfferImage();

        foreach ($_REQUEST as $k => $v) {
            if ($v != "") {
                $get_edited[$k] = $v;
            }
        }

        $offers->setId($get_edited['offer_id']);
        $offers->setValues($get_edited);
        $offers->setFromDate(date('Y-m-d', strtotime($get_edited['from_date'])));
        $offers->setToDate(date('Y-m-d', strtotime($get_edited['to_date'])));
        if ($offers->update()) {
            //Sessions::setTourBannerId($get_edited['id']);
            Sessions::getUploadedOfferImage('');
            Common::jsonSuccess("Offers Updated Successfully!");
        } else {
            Common::jsonError("Error");
        }
    }

    function delete()
    {
        $offerId = $_REQUEST['id'];

        $offers = new Offers();
        $offers->setId($offerId);
        $data = $offers->getById();
        $offers->extractor($data);

        $hotelID = $offers->hotelId();

        if ($offers->delete()) {
            $path = DOC_ROOT . 'uploads/special_offers/' . $offers->image();
            if (file_exists($path)) {
                unlink($path);
            }
            $specialOffers = new Offers();
            $specialOffers->setHotelId($hotelID);
            $specialOffers_rows = $specialOffers->getByHotelId();

            if (count($specialOffers_rows) == 0) {
                $complete = new ProfileCompletion();
                $complete->setHotelStepHotelsId($hotelID);
                $complete->setHotelStep1(0);
                $complete->updateProfileCompletionStepByHotel('9');
                Common::jsonSuccess("Offer Deleted Successfully", "setOfferStep");
            } else {
                Common::jsonSuccess("Offer Deleted Successfully");
            }
        } else {
            Common::jsonError("Error");
        }

    }

    function removeOfferImage()
    {
        $offerId = $_REQUEST['offerId'];
        $file = $_REQUEST['image'];
        $file_path = DOC_ROOT . 'uploads/special_offers/' . $file;

        $offers = new Offers();

        if (file_exists($file_path)) {
            if (unlink($file_path)) {
                $offers->setId($_REQUEST['offerId']);
                $offers->deleteImage();
                Common::jsonSuccess("Offer image deleted successfully");
            } else {
                Common::jsonError("Failed to delete");
            }
        } else {
            Common::jsonError("Error");
        }
    }

    function viewTable($data, $count)
    {

        $offers = new Offers();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("view");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Offers</span>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
            <colgroup>
                <col class="con0"/>
                <col class="con1"/>
            </colgroup>
            <thead>
            <tr>
                <th class="head1">Title</th>
                <th class="head0">From Date</th>
                <th class="head0">To Date</th>
                <th class="head0">Status</th>
                <th class="head1">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data) > 0) { ?>

                <?php
                for ($i = 0; $i < count($data); $i++) {
                    $offers->extractor($data, $i);

                    $status = Libs::get("all_status");
                    ?>
                    <tr id="row_<?php echo $offers->id(); ?>">
                        <td class="con1"><?php echo $offers->title(); ?></td>
                        <td class="con1"><?php echo $offers->fromDate(); ?></td>
                        <td class="con1"><?php echo $offers->toDate(); ?></td>
                        <td class="con0"><?php echo $status[$offers->status()]; ?></td>
                        <td class="center">
                            <a onclick="loadGUIContent('offers','edit','<?php echo $offers->id(); ?>')">Edit</a>
                            <a onclick="_delete(<?php echo $offers->id(); ?>)" class="toggle">Delete</a>
                            <!--                                <a href="offers.php?id=-->
                            <?php //echo $offers->id(); ?><!--" >Edit</a> | <a href="javascript:;" onclick="_delete(-->
                            <?php //echo $offers->id(); ?><!--)" class="toggle">Delete</a>-->
                        </td>
                    </tr>
                <?php
                }
                ?>

            <?php } ?>
            </tbody>
        </table>

        <?php

        $paginations->drawPagination();

    }

    function validOffers(){
        $from=$_REQUEST['from'];
        $to=$_REQUEST['to'];
        $room_type=$_REQUEST['room_type'];
        $bed=$_REQUEST['bed'];
        $meal=$_REQUEST['meal'];
        $num_rooms=$_REQUEST['num_rooms'];

        $offers=new Offers();
        $offerArr=$offers->validOffers($from, $to, $room_type, $bed, $meal,$num_rooms);

        echo json_encode($offerArr);
    }

    function getAVailableOffers(){
        $from=$_REQUEST['from'];
        $to=$_REQUEST['to'];
        $room_type=$_REQUEST['room_type'];

        $offers=new Offers();
        $offerArr=$offers->getAvailableOffers($from, $to, $room_type);

        echo json_encode($offerArr);
    }

    function loadOffersForHotel(){
        $from_date=$_REQUEST['from_date'];
        $hotel_id=$_REQUEST['hotel_id'];

        $offers=new Offers();
        $offerArr=$offers->loadOffersForHotel($from_date,$hotel_id);

        $offerContent="";
        $offerAvailable=false;
        if(count($offerArr)>0){
            $offerAvailable=true;
            $offerContent="
            <div>
                <div class='group-set' style='width: 100%;'>
                    <div class='front-offers'>";
                            foreach($offerArr as $offer){
            $offerContent = $offerContent. "
                                <div class='offers'>
                                    <h4>";
                                        $room=new HotelRoomType();
                                        $room->setRoomTypeId($offer['room_type']);
                                        $room->extractor($room->getHotelRoomTypeFromId());
                                $offerContent = $offerContent. "Room: " . $room->roomTypeName() . " | " . $offer['title'];
                                        $room=null;

                                $offerContent = $offerContent. "</h4>
                                    <div  class='desc clearfix'>". $offer['des'] ."</div>
                                    <div class='offer-image clearfix'>";
                                         if ($offer['image'] != '' && file_exists(DOC_ROOT.'uploads/special_offers/'.$offer['image'])) {
                                             $offerContent = $offerContent. "<img style='max-width: 100%; max-height: 100%;' src='". HTTP_PATH ."uploads/special_offers/". $offer['image'] ."' />";
                                         }
                                $offerContent = $offerContent. "</div>
                                    <div class='clearfix detail'>
                                        <ul class='offerFe'>
                                            <li>Offer type : ";

                                                    if($offer['dis_type']==0){
                                                        $offerContent = $offerContent. "Fixed Price";
                                                    }elseif($offer['dis_type']==1){
                                                        $offerContent = $offerContent. "Percentage Discount";
                                                    }elseif($offer['dis_type']==2){
                                                        $offerContent = $offerContent. "Free Nights";
                                                    }elseif($offer['dis_type']==3){
                                                        $offerContent = $offerContent. "Custom";
                                                    }
                                $offerContent = $offerContent. "</li>
                                            <li>"; if($offer['date_validity']=='on'){$offerContent = $offerContent. "Only for ";}else{$offerContent = $offerContent. "For ";}  $offerContent = $offerContent. "bookings between " . $offer['from_date'] ." & ". $offer['to_date']."</li>
                                            <li>Offer available for
                                                <ul>
                                                    <li>Beds:";
                                                            $beds=Libs::get('bed_type');
                                                            foreach(array_filter(explode(':',$offer['bed_type'])) as $bed){
                                                                $offerContent = $offerContent. $beds[$bed] ."/ ";
                                                                if($offerContent<>""){
                                                                    $offerContent = $offerContent. $beds[$bed] ."/ ";
                                                                }else{
                                                                    $offerContent = $offerContent. $beds[$bed];
                                                                }
                                                            }
                                $offerContent = $offerContent. "</li>
                                                    <li>Meals:";
                                                            $meals=Libs::get('meal_type');
                                                            foreach(array_filter(explode(':',$offer['meal_type'])) as $meal){
                                                                $offerContent = $offerContent. $meals[$meal] . "/ ";
                                                            }
                                $offerContent = $offerContent. "</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class='clearfix'></div>
                                </div>";
                            }
            $offerContent = $offerContent. "</div>
                    </div>
                </div>";
        }else{
            $offerAvailable=false;
        }
        $offerArray= array("offerAvailable" => $offerAvailable, "offerContent" => $offerContent);
        echo json_encode($offerArray);
    }

    function loadHotelsWithOffers(){
        $from_date=date('Y-m-d');;
        $hotel_id=$_REQUEST['hotel_id'];

        $offers=new Offers();
        $offerArr=$offers->loadOffersForHotel($from_date,$hotel_id);

        $offerContent="";
        $offerAvailable=false;
        if(count($offerArr)>0){
            $offerAvailable=true;
            $offerContent="
            <div>
                <div class='group-set' style='width: 100%;'>
                    <div class='front-offers'>";
                            foreach($offerArr as $offer){
            $offerContent = $offerContent. "
                                <div class='offers'>
                                    <h4>";
                                        $room=new HotelRoomType();
                                        $room->setRoomTypeId($offer['room_type']);
                                        $room->extractor($room->getHotelRoomTypeFromId());
                                $offerContent = $offerContent. "Room: " . $room->roomTypeName() . " | " . $offer['title'];
                                        $room=null;

                                $offerContent = $offerContent. "</h4>
                                    <div  class='desc clearfix'>". $offer['des'] ."</div>
                                    <div class='offer-image clearfix'>";
                                         if ($offer['image'] != '' && file_exists(DOC_ROOT.'uploads/special_offers/'.$offer['image'])) {
                                             $offerContent = $offerContent. "<img style='max-width: 100%; max-height: 100%;' src='". HTTP_PATH ."uploads/special_offers/". $offer['image'] ."' />";
                                         }
                                $offerContent = $offerContent. "</div>
                                    <div class='clearfix detail'>
                                        <ul class='offerFe'>
                                            <li>Offer type : ";

                                                    if($offer['dis_type']==0){
                                                        $offerContent = $offerContent. "Fixed Price";
                                                    }elseif($offer['dis_type']==1){
                                                        $offerContent = $offerContent. "Percentage Discount";
                                                    }elseif($offer['dis_type']==2){
                                                        $offerContent = $offerContent. "Free Nights";
                                                    }elseif($offer['dis_type']==3){
                                                        $offerContent = $offerContent. "Custom";
                                                    }
                                $offerContent = $offerContent. "</li>
                                            <li>"; if($offer['date_validity']=='on'){$offerContent = $offerContent. "Only for ";}else{$offerContent = $offerContent. "For ";}  $offerContent = $offerContent. "bookings between " . $offer['from_date'] ." & ". $offer['to_date']."</li>
                                            <li>Offer available for
                                                <ul>
                                                    <li>Beds:";
                                                            $beds=Libs::get('bed_type');
                                                            foreach(array_filter(explode(':',$offer['bed_type'])) as $bed){
                                                                $offerContent = $offerContent. $beds[$bed] ."/ ";
                                                                if($offerContent<>""){
                                                                    $offerContent = $offerContent. $beds[$bed] ."/ ";
                                                                }else{
                                                                    $offerContent = $offerContent. $beds[$bed];
                                                                }
                                                            }
                                $offerContent = $offerContent. "</li>
                                                    <li>Meals:";
                                                            $meals=Libs::get('meal_type');
                                                            foreach(array_filter(explode(':',$offer['meal_type'])) as $meal){
                                                                $offerContent = $offerContent. $meals[$meal] . "/ ";
                                                            }
                                $offerContent = $offerContent. "</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class='clearfix'></div>
                                </div>";
                            }
            $offerContent = $offerContent. "</div>
                    </div>
                </div>";
        }else{
            $offerAvailable=false;
        }
        $offerArray= array("offerAvailable" => $offerAvailable, "offerContent" => $offerContent);
        echo json_encode($offerArray);
    }

?>