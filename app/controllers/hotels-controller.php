<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];
    $edit_section = explode("_", $action);

    switch ($action) {

        case "viewHotels":
            viewHotels();
            break;
        case "viewPendingDeactivationHotels":
            viewPendingDeactivationHotels();
            break;
        case "viewDeactivatedHotels":
            viewDeactivatedHotels();
            break;
        case "viewHotelsSearch":
            viewHotelsSearch();
            break;
        case "addHotelFirstTime":
            addHotelFirstTime();
            break;
        case "updateHotelsStep_" . $edit_section[1]:
            call_user_func("updateHotelsStep_" . $edit_section[1]);
            break;
        case "deleteHotel":
            deleteHotel();
            break;
        case "activateHotel":
            activateHotel();
            break;
        case "deactivateHotelRequest":
            deactivateHotelRequest();
            break;
        case "deactivateHotelRequestCancel":
            deactivateHotelRequestCancel();
            break;
        case "deleteRoom":
            deleteRoom();
            break;
        case "editHotelFirst":
            editHotelFirst();
            break;
        case "loginHotels":
            loginHotels();
            break;
        case "logout":
            logout();
            break;
        case "activeHotel":
            activeHotel();
            break;
        case "activeHotelFeatured":
            activeHotelFeatured();
            break;
        case "viewHotelsFront":
            viewHotelsFront();
            break;
        case "viewSpecialOfferHotelsFront":
            viewSpecialOfferHotelsFront();
            break;
        case "hotelImageUploadProfileComplete":
            hotelImageUploadProfileComplete();
            break;
        case "loadHotelImages":
            loadHotelImages();
            break;
        case "loadRoomImages":
            loadRoomImages();
            break;
        case "saveImageDesc":
            saveImageDesc();
            break;
        case "loadRoomImagesForSlider":
            loadRoomImagesForSlider();
            break;
        case "removeHotelImage":
            removeHotelImage();
            break;
        case "selectDataFromRoomType":
            selectDataFromRoomType();
            break;
        case "CheckHotelEmail":
            CheckHotelEmail();
            break;
        case "CheckSEOUrl":
            CheckSEOUrl();
            break;

    }

    function CheckHotelEmail()
    {
        $hotel = new Hotels();
        $hotel->setHotelId($_REQUEST['hotel_id']);
        $hotel->setHotelEmail($_REQUEST['hotel_email']);
        $details = $hotel->isHotelEmailExists();
        echo $details;
    }

    function CheckSEOUrl()
    {
        $hotel = new Hotels();
        $hotel->setHotelId($_REQUEST['hotel_id']);
        $hotel->setHotelSeoUrl($_REQUEST['hotel_seo_url']);
        $details = $hotel->isSeoUrlExists();
        echo $details;
    }

    function loadHotelImages()
    {
        $hotel_id = $_REQUEST['hotel_id'];

        $divContents = "";
        $a = 0;
        foreach (glob(DOC_ROOT . 'uploads/hotel-gal/' . $hotel_id . '_' . "*.*") as $filename) {
            $hotelImages = new HotelImages();
            $hotelImages->setImageHotelId($hotel_id);
            $hotelImages->setImageName(basename($filename));
            $hotelImages = $hotelImages->getImageDetailFromImage();
            $divContents .= "<div class='img_gal img_" . $a . "'>
                    <img src='" . HTTP_PATH . "uploads/hotel-gal/" . basename($filename) . "' class='img_" . $a . "'/>
                    <div class='overlay img_" . $a . "'></div>
                    <div class='button img_" . $a . "' onclick=removeHotelImage('" . basename($filename) . "','" . $a . "')></div>
                    <input name='image_title_" . $a . "' id='image_title_" . $a . "' type='text' class='imgDesc' value='" . $hotelImages[0]['image_title'] . "' onBlur=saveImageDesc('" . $hotel_id . "','" . $hotelImages[0]['image_id'] . "','image_title_" . $a . "') />
                </div>";
            $a++;
        }
        echo json_encode($divContents);
    }

    function saveImageDesc()
    {
        $hotelImages = new HotelImages();
        $hotelImages->setImageHotelId($_REQUEST['hotel_id']);
        $hotelImages->setImageId($_REQUEST['image_id']);
        $hotelImages->setImageTitle($_REQUEST['image_title']);
        if ($hotelImages->updateImageTitle()) {
            Common::jsonSuccess("Hotel image title saved successfully");
        } else {
            Common::jsonError("Failed to save image title ");
        }
    }

    function loadRoomImages()
    {
        $room_id = $_REQUEST['room_id'];
        $divContents = "";
        $a = 0;
        foreach (glob(DOC_ROOT . 'uploads/room-gal/' . $room_id . '_' . "*.*") as $filename) {
            $divContents .= "<div class='img_gal img_" . $a . "'>
                    <img src='" . HTTP_PATH . "uploads/room-gal/" . basename($filename) . "' class='img_" . $a . "'/>
                    <div class='overlay img_" . $a . "'></div>
                    <div class='button img_" . $a . "' onclick=removeRoomImage('" . basename($filename) . "','" . $a . "')></div>
                </div>";
            $a++;
        }
        echo json_encode($divContents);
    }

    function loadRoomImagesForSlider()
    {
        $room_id = $_REQUEST['room_id'];
        $divContents = "";
        $a = 0;
        //        foreach (glob(DOC_ROOT . 'uploads/room-gal/' . $room_id . '_' . "*.*") as $filename) {
        //            $divContents.="<div><img u=image src='" . HTTP_PATH . "uploads/room-gal/" . basename($filename) . "' /><div u='thumb'></div></div>";
        //            $a++;
        //        }
        foreach (glob(DOC_ROOT . 'uploads/room-gal/' . $room_id . '_' . "*.*") as $filename) {
            $divContents .= "<li><img  title = '' src='" . HTTP_PATH . "uploads/room-gal/" . basename($filename) . "' /></li>";
            $a++;
        }
        echo json_encode($divContents);
    }

    function removeHotelImage()
    {
        $file = $_REQUEST['image'];
        $file_path = DOC_ROOT . 'uploads/hotel-gal/' . $file;

        if (file_exists($file_path)) {
            if (unlink($file_path)) {
                Common::jsonSuccess("Hotel image Deleted Successfully");
            } else {
                Common::jsonError("Fail To Delete");
            }
        } else {
            Common::jsonError("Error");
        }
    }

    function hotelImageUploadProfileComplete()
    {
        $complete = new ProfileCompletion();
        $complete->setHotelStepId($_REQUEST['hotel_step_id']);
        $complete->setHotelStep1(1);
        $complete->updateProfileCompletionStep('8');
        echo($_REQUEST['hotel_step_id']);
        Common::jsonSuccess("");
    }

    function viewHotels()
    {
        $hotel = new Hotels();
        $data = $hotel->getAllHotelsPaginated($_REQUEST['page']);
        $count = $hotel->getAllHotelsCount();
        viewTable($data, $count[0]['count']);
    }

    function viewPendingDeactivationHotels()
    {
        $hotel = new Hotels();
        $data = $hotel->getPendingDeactivationHotelsPaginated($_REQUEST['page']);
        $count = $hotel->getPendingDeactivationHotelsCount();
        viewPendingDeactivationTable($data, $count[0]['count']);
    }

    function viewDeactivatedHotels()
    {
        $hotel = new Hotels();
        $data = $hotel->getDeactivatedHotelsPaginated($_REQUEST['page']);
        $count = $hotel->getDeactivatedHotelsCount();
        viewDeactivatedTable($data, $count[0]['count']);
    }

    function viewHotelsSearch()
    {
        $hotel = new Hotels();
        $data = $hotel->getHotelsBySearchPaginated($_REQUEST['page'], $_REQUEST['search_str']);
        $count = $hotel->getSearchedHotelsCount($_REQUEST['search_str']);
        viewTableSearch($data, $count[0]['count'], $_REQUEST['search_str']);
    }

    function viewHotelsFront()
    {
        $hotel = new Hotels();
        $data = $hotel->getAllHotelsWithDiscountFront($_REQUEST['page']);
        $count = $hotel->getAllHotelsDiscountCountFront();
        viewTableFront($data, $count[0]['count']);
    }

    function viewSpecialOfferHotelsFront()
    {
        $hotel = new Hotels();
        $data = $hotel->getAllHotelsWithSpecialOffersFront($_REQUEST['page']);
        $count = $hotel->getAllHotelsWithOffersCountFront();
        viewTableSpecialOfferHotels($data, $count[0]['count']);
    }

    function selectDataFromRoomType()
    {
        $hotel = new Hotels();
        $data = $hotel->selectDataFromRoomType($_REQUEST['roomTypeId']);
        print_t($data);
    }

    function activeHotel()
    {
        $hotel = new Hotels();
        $members = new Members();
        $mailClass = new mailClass();

        $status = $_REQUEST['hotel_status'];

        $hotel->setHotelId($_REQUEST['hotels_id']);

        $hotel->extractor($hotel->getHotelFromId());
        $members->setMemberId($hotel->hotelMemberId());
        $members->extractor($members->getMemberFromId());

        $hotel->setHotelActiveStatus($status);

        if ($hotel->updateHotelStatus()) {
            if ($_REQUEST['hotel_status'] == Libs::getKey("hotel_status_admin", "Active")) {
                $mailClass->HotelActivationSuccess($members->memberTitle(), $members->memberFirstName(), $members->memberLastName(), $members->memberEmail(), $hotel->hotelName(), $hotel->hotelSeoUrl());
            }
            Common::jsonSuccess("Updated");
        } else {
            Common::jsonError("Error");
        }
    }

    function activeHotelFeatured()
    {
        $hotel = new Hotels();
        $status = 0;

        if ($_REQUEST['hotel_status'] == 0) {
            $status = 1;
        } else if ($_REQUEST['hotel_status'] == 1) {
            $status = 0;
        }

        $hotel->setHotelId($_REQUEST['hotels_id']);
        $hotel->setHotelsFeaturedStatus($status);

        if ($hotel->updateFeaturedStatus()) {
            Common::jsonSuccess("updated");
        } else {
            Common::jsonError("Error");
        }
    }

    function addHotelFirstTime()
    {
        $hotel = new Hotels();
        $members = new Members();
        $mailClass = new mailClass();

        $members->setMemberId(Sessions::getMemberId());
        $members->extractor($members->getMemberFromId());

        $hotel->setValues($_REQUEST);
        $hotel->setHotelSeoUrl($_REQUEST['seo']);
        $hotel_seo = $hotel->getHotelIdFromSeoName();

        if ($hotel_seo == 0) {
            $hotel_id = $hotel->addHotelFirstTime();
            if ($hotel_id) {
                //INFO: Log
                //$temp_hotel = $_REQUEST;
                //$TransactionLog=new TransactionLog($hotel_id,Libs::getKey('hotel_sections','Property Details'),'Insert',Sessions::getMemberId(),'hotels',$temp_hotel,'');
                //$TransactionLog->log();
                //$temp_hotel=null;
                //INFO: Log//
                $profilecomplete = new ProfileCompletion();
                $profilecomplete->setHotelStepHotelsId($hotel_id);
                $profilecomplete->setHotelStep1(1);
                $profilecomplete->newProfileCompletion();

                $mailClass->HotelRegistration($members->memberTitle(), $members->memberFirstName(), $members->memberLastName(), $members->memberEmail(), $_REQUEST['hotel_name'], $_REQUEST['hotel_email'], $_REQUEST['hotel_email']);
                $hotel = null;
            }
            echo $hotel_id;
        } else {
            echo "Failed";
        }
    }

    function editHotelFirst()
    {
        //print_r($_REQUEST);
        $hotel = new Hotels();
        $hotel->setValues($_REQUEST);

        //INFO: Log
        //$temp_hotel1 = new Hotels();
        //$temp_hotel2 = $_REQUEST;
        //$temp_hotel1->setHotelId($hotel->hotelId());
        //$temp_hotel1=(array)$temp_hotel1->getHotelFromId();
        //INFO: Log//

        if ($hotel->editHotelFirst()) {
            //INFO: Log
            //$TransactionLog=new TransactionLog($hotel->hotelId(),Libs::getKey('hotel_sections','Property Details'),'Update',Sessions::getMemberId(),'hotels',$temp_hotel1[0],$temp_hotel2);
            //$TransactionLog->log();
            //INFO: Log//
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
        //INFO: Log
        //$temp_hotel1=null;
        //$temp_hotel2=null;
        //INFO: Log//
    }

    function updateHotelsStep_1()
    {

        $hotel = new Hotels();
        $hotel->setValues($_REQUEST);

        //INFO: Log
        //$temp_hotel1 = new Hotels();
        //$temp_hotel2 = $_REQUEST;
        //$temp_hotel1->setHotelId($temp_hotel2['hotel_id']);
        //$temp_hotel1=(array)$temp_hotel1->getHotelFromId();
        //INFO: Log//

        if ($hotel->updateHotelsStep_1()) {
            //INFO: Log
            //$TransactionLog=new TransactionLog($hotel->hotelId(),Libs::getKey('hotel_sections','Hotel Style'),'Update',Sessions::getMemberId(),'hotels',$temp_hotel1[0],$temp_hotel2);
            //$TransactionLog->log();
            //INFO: Log
            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('2');
            echo($_REQUEST['hotel_step_id']);
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
        //INFO: Log
        //$temp_hotel1=null;
        //$temp_hotel2=null;
        //INFO: Log
    }

    function updateHotelsStep_2()
    {
        $hotel = new Hotels();
        $hotel->setValues($_REQUEST);

        //INFO: Log
        //$temp_hotel1 = new Hotels();
        //$temp_hotel2 = $_REQUEST;
        //$temp_hotel1->setHotelId($temp_hotel2['hotel_id']);
        //$temp_hotel1=(array)$temp_hotel1->getHotelFromId();
        //INFO: Log//
        if ($hotel->updateHotelsStep_2()) {
            //INFO: Log
            //$TransactionLog=new TransactionLog($hotel->hotelId(),Libs::getKey('hotel_sections','Hotel Facilities'),'Update',Sessions::getMemberId(),'hotels',$temp_hotel1[0],$temp_hotel2);
            //$TransactionLog->log();
            //INFO: Log//

            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('3');
            echo($_REQUEST['hotel_step_id']);
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
        //INFO: Log
        //$temp_hotel1=null;
        //$temp_hotel2=null;
        //INFO: Log//
    }

    function updateHotelsStep_3() //Add Room Type
    {
        $hotelroomtype = new HotelRoomType();
        $_REQUEST['room_type_img'] = Sessions::getRoomImage();
        $hotelroomtype->setValues($_REQUEST);

        //$hotelroomtype->setRoomTypeImg();
        if ($hotelroomtype->newHotelRoomType()) {

            //INFO: Log
            //$temp_room_type = $_REQUEST;
            //$TransactionLog=new TransactionLog($temp_room_type['room_type_hotel_id'],Libs::getKey('hotel_sections','Room Types - Add'),'Insert',Sessions::getMemberId(),'hotel_room_types',$temp_room_type,'');
            //$TransactionLog->log();
            //$temp_room_type=null;
            //INFO: Log//

            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('4');
            echo($_REQUEST['hotel_step_id']);
            Sessions::setRoomImage("");
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
    }

    function updateHotelsStep_4()
    {
        $hotel = new Hotels();
        $hotel->setValues($_REQUEST);

        //INFO: Log
        //$temp_hotel1 = new Hotels();
        //$temp_hotel2 = $_REQUEST;
        //$temp_hotel1->setHotelId($hotel->hotelId());
        //$temp_hotel1=(array)$temp_hotel1->getHotelFromId();
        //$TransactionLog=new TransactionLog($hotel->hotelId(),Libs::getKey('hotel_sections','Useful Info'),'Update',Sessions::getMemberId(),'hotels',$temp_hotel1[0],$temp_hotel2);
        //$TransactionLog->log();
        //$temp_hotel1=null;
        //$temp_hotel2=null;
        //INFO: Log//

        if ($hotel->updateHotelsStep_4()) {

            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('5');
            echo($_REQUEST['hotel_step_id']);
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
    }

    function updateHotelsStep_5()
    {
        $room_control = new RoomControl();

        $rc_id = $_REQUEST['rc_id'];
        $rc_room_id = $_REQUEST['rc_room_type_id'];
        $rc_in_date = $_REQUEST['rc_in_date'];
        $rc_out_date = $_REQUEST['rc_out_date'];
        $rc_num_room = $_REQUEST['rc_num_of_rooms'];

        $room_control->setRcId($_REQUEST['rc_id']);
        $res1 = $room_control->getRoomControlData();

        if (count($res1) > 0) {
            $res = $room_control->editRoomController($rc_id, $rc_num_room);
        } else {
            $res = $room_control->getAllRoomDates($rc_in_date, $rc_out_date, $rc_room_id);
            $room_control->addRoomController($rc_in_date, $rc_out_date, $rc_room_id, $rc_num_room, $res);
        }
        //INFO: Log
        if ($res) {
            //$temp_room_control = array("Room_Id" => $rc_room_id, "Date_From" => $rc_in_date, "Date_to" => $rc_out_date, "No_of_Rooms" => $rc_num_room);
            //$TransactionLog = new TransactionLog($_REQUEST['hotel_id'], Libs::getKey('hotel_sections', 'Assign Room'), 'Insert', Sessions::getMemberId(), 'room_control', $temp_room_control, '');
            //$TransactionLog->log();
            //$temp_room_control = null;
        } else {

        }
        //INFO: Log//

        $complete = new ProfileCompletion();
        $complete->setHotelStepId($_REQUEST['hotel_step_id']);
        $complete->setHotelStep1(1);
        $complete->updateProfileCompletionStep('7');
        echo($_REQUEST['hotel_step_id']);

    }

    function updateHotelsStep_6() //Edit Room Type
    {

        $hotelroomtype = new HotelRoomType();
        $_REQUEST['room_type_img'] = Sessions::getRoomImage();
        $hotelroomtype->setValues($_REQUEST);
        //INFO: Log
        //$temp_room_type1 = new HotelRoomType();
        //$temp_room_type2 = $_REQUEST;
        //$temp_room_type1->setRoomTypeId($temp_room_type2['room_type_id']);
        //$temp_room_type1=(array)$temp_room_type1->getHotelRoomTypeFromId();
        //INFO: Log//
        if ($hotelroomtype->updateHotelRoomType()) {
            //INFO: Log
            //$TransactionLog=new TransactionLog($temp_room_type2['room_type_hotel_id'],Libs::getKey('hotel_sections','Room Types - Edit'),'Update',Sessions::getMemberId(),'hotel_room_types',$temp_room_type1[0],$temp_room_type2);
            //$TransactionLog->log();
            //INFO: Log//
            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('7');
            echo($_REQUEST['hotel_step_id']);
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
        //INFO: Log
        //$temp_room_type1=null;
        //$temp_room_type2=null;
        //INFO: Log
    }

    function deleteRoom()
    {
        $hotelroomtype = new HotelRoomType();
        $hotelroomtype->setRoomTypeId($_REQUEST['room_type_id']);
        //INFO: Log
        //$temp_room_type1 = new HotelRoomType();
        //$temp_room_type1->setRoomTypeId($_REQUEST['room_type_id']);
        //$temp_room_type1=(array)$temp_room_type1->getHotelRoomTypeFromId();
        //INFO: Log//
        if ($hotelroomtype->deleteHotelRoomType()) {
            //INFO: Log
            //$TransactionLog=new TransactionLog($temp_room_type1[0]['room_type_hotel_id'],Libs::getKey('hotel_sections','Room Types - Delete'),'Delete',Sessions::getMemberId(),'hotel_room_types',$temp_room_type1[0],'');
            //$TransactionLog->log();
            //INFO: Log//
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
        //INFO: Log
        //$temp_room_type1=null;
        //INFO: Log//
    }

    function loginHotels()
    {
        $username = $_REQUEST['hotel_email'];
        $password = $_REQUEST['hotel_password'];
        $session = new Sessions();

        $hotel = new Hotels();
        $hotel->setHotelEmail($username);
        $data = $hotel->getHotelFromEmailID();
        if (count($data) > 0) {
            $hotel->extractor($data);
            if (strcmp($hotel->hotelPassword(), md5($password)) == 0) {
                $session->setHotelsLoginSessions($hotel->hotelId(), $hotel->hotelName());
                Common::jsonSuccess("Success");
            } else {
                Common::jsonError("Login Error");
            }
        } else {
            Common::jsonError("Login Error");
        }
    }

    function logout()
    {
        $sessions = new Sessions();
        $sessions->logoutMember();
        $sessions->logoutClient();
        $sessions->logoutHotels();
        header("Location: " . HTTP_PATH . "hotels");
    }

    function deleteHotel()
    {
        $hotel = new Hotels();
        $members = new Members();
        $mailClass = new mailClass();

        $hotel->setHotelId($_REQUEST['id']);
        $hotel->extractor($hotel->getHotelFromId());
        $members->setMemberId($hotel->hotelMemberId());
        $members->extractor($members->getMemberFromId());

        $hotel->setHotelActiveStatus(Libs::getKey("hotel_status_admin", "Deactivated"));

        //INFO: Log
        //$temp_hotel1 = new Hotels();
        //$temp_hotel1->setHotelId($_REQUEST['id']);
        //$temp_hotel1=(array)$temp_hotel1->getHotelFromId();
        //$TransactionLog=new TransactionLog($admin->hotelId(),Libs::getKey('hotel_sections','Property Details'),'Delete',Sessions::getMemberId(),'hotels',$temp_hotel1[0],'');
        //$TransactionLog->log();
        //$temp_hotel1=null;
        //INFO: Log//
        if ($hotel->changeHotelActiveStatus()) {
            $mailClass->HotelDeactivationSuccess($members->memberTitle(), $members->memberFirstName(), $members->memberLastName(), $members->memberEmail(), $hotel->hotelName());
            Common::jsonSuccess("Hotel Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }
    }

    function activateHotel()
    {
        $hotel = new Hotels();
        $members = new Members();
        $mailClass = new mailClass();

        $hotel->setHotelId($_REQUEST['id']);
        $hotel->extractor($hotel->getHotelFromId());
        $members->setMemberId($hotel->hotelMemberId());
        $members->extractor($members->getMemberFromId());

        $hotel->setHotelActiveStatus(Libs::getKey("hotel_status_admin", "Inactive"));

        //INFO: Log
        //$temp_hotel1 = new Hotels();
        //$temp_hotel1->setHotelId($_REQUEST['id']);
        //$temp_hotel1=(array)$temp_hotel1->getHotelFromId();
        //$TransactionLog=new TransactionLog($admin->hotelId(),Libs::getKey('hotel_sections','Property Details'),'Delete',Sessions::getMemberId(),'hotels',$temp_hotel1[0],'');
        //$TransactionLog->log();
        //$temp_hotel1=null;
        //INFO: Log//
        if ($hotel->changeHotelActiveStatus()) {
            Common::jsonSuccess("Hotel Activated Successfully");
        } else {
            Common::jsonError("Error");
        }
    }

    function deactivateHotelRequest()
    {
        $hotel = new Hotels();
        $members = new Members();
        $mailClass = new mailClass();

        $hotel->setHotelId($_REQUEST['id']);
        $hotel->extractor($hotel->getHotelFromId());
        $members->setMemberId($hotel->hotelMemberId());
        $members->extractor($members->getMemberFromId());

        $hotel->setHotelActiveStatus(Libs::getKey("hotel_status_admin", "Deactivation Pending"));
        //INFO: Log
        //$temp_hotel1 = new Hotels();
        //$temp_hotel1->setHotelId($_REQUEST['id']);
        //$temp_hotel1=(array)$temp_hotel1->getHotelFromId();
        //$TransactionLog=new TransactionLog($hotel->hotelId(),Libs::getKey('hotel_sections','Property Details'),'Delete',Sessions::getMemberId(),'hotels',$temp_hotel1[0],'');
        //$TransactionLog->log();
        //$temp_hotel1=null;
        //INFO: Log//
        if ($hotel->changeHotelActiveStatus()) {
            $mailClass->HotelDeactivationRequest($members->memberTitle(), $members->memberFirstName(), $members->memberLastName(), $hotel->hotelName());
            Common::jsonSuccess("Deactivation request successful");
        } else {
            Common::jsonError("Error");
        }
    }

    function deactivateHotelRequestCancel()
    {
        $hotel = new Hotels();
        $members = new Members();
        $mailClass = new mailClass();

        $hotel->setHotelId($_REQUEST['id']);
        $hotel->extractor($hotel->getHotelFromId());
        $members->setMemberId($hotel->hotelMemberId());
        $members->extractor($members->getMemberFromId());

        $hotel->setHotelActiveStatus(Libs::getKey("hotel_status_admin", "Active"));
        //INFO: Log
        //$temp_hotel1 = new Hotels();
        //$temp_hotel1->setHotelId($_REQUEST['id']);
        //$temp_hotel1=(array)$temp_hotel1->getHotelFromId();
        //$TransactionLog=new TransactionLog($hotel->hotelId(),Libs::getKey('hotel_sections','Property Details'),'Delete',Sessions::getMemberId(),'hotels',$temp_hotel1[0],'');
        //$TransactionLog->log();
        //$temp_hotel1=null;
        //INFO: Log//
        if ($hotel->changeHotelActiveStatus()) {
            $mailClass->HotelDeactivationRequestCancel($members->memberTitle(), $members->memberFirstName(), $members->memberLastName(), $hotel->hotelName());
            Common::jsonSuccess("Deactivation Cancel request successful");
        } else {
            Common::jsonError("Error");
        }
    }

    function viewTable($data, $count)
    {

        $hotel = new Hotels();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewHotels");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Hotel</span>
        </div>
        <div class="mws-panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
            <thead>
            <tr>
                <th>Hotel Name</th>
                <th>Hotel Hits</th>
                <th>Active Status</th>
                <th>Featured Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data) > 0) { ?>

                <?php
                for ($i = 0; $i < count($data); $i++) {
                    $hotel->extractor($data, $i);
                    $hotel_status = Libs::get("hotel_status_normal");
                    ?>
                    <tr id="row_<?php echo $hotel->hotelId(); ?>">
                        <td><?php echo $hotel->hotelName(); ?></td>
                        <td><?php echo $hotel->hotelHits(); ?></td>
                        <td>

                            <select id="hotels_status_<?php echo $hotel->hotelId(); ?>" onchange="hotelActiveStatus(<?php echo($hotel->hotelId()); ?>)">
                                <?php
                                    foreach ($hotel_status as $key => $val) {
                                        ?>
                                        <option <?php if ($hotel->hotelActiveStatus() == $key) {
                                            echo 'selected="selected"';
                                        } ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                    <?php
                                    }
                                ?>
                            </select>
                        </td>
                        <td>

                            <select id="hotels_feature_status_<?php echo $hotel->hotelId(); ?>" onchange="hotelsFeaturedStatus(<?php echo($hotel->hotelId()); ?>,<?php echo($hotel->hotelsFeaturedStatus()); ?>)">
                                <option <?php if ($hotel->hotelsFeaturedStatus() == 1) {
                                    echo 'selected="selected"';
                                } ?> style="color:#469400;" value="1">Featured
                                </option>
                                <option <?php if ($hotel->hotelsFeaturedStatus() == 0) {
                                    echo 'selected="selected"';
                                } ?> style="color:#900;" value="0">Not Featured
                                </option>
                            </select>

                        </td>
                        <td>
                            <a onclick="login_as_hotels('<?php echo $hotel->hotelId(); ?>');" style="cursor:pointer;">Login as the Hotel</a> &nbsp;
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

    function viewPendingDeactivationTable($data, $count)
    {

        $hotel = new Hotels();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewPendingDeactivationHotels");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">Deactivation Pending Hotels</span>
        </div>
        <div class="mws-panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
            <thead>
            <tr>
                <th>Hotel Name</th>
                <th>Hotel Hits</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data) > 0) { ?>

                <?php
                for ($i = 0; $i < count($data); $i++) {
                    $hotel->extractor($data, $i);
                    $hotel_status = Libs::get("hotel_status_normal");
                    ?>
                    <tr id="row_<?php echo $hotel->hotelId(); ?>">
                        <td><?php echo $hotel->hotelName(); ?></td>
                        <td><?php echo $hotel->hotelHits(); ?></td>
                        <td>
                            <a onclick="deleteHotel('<?php echo $hotel->hotelId(); ?>');" style="cursor:pointer; color: red;">Deactivate</a>
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

    function viewDeactivatedTable($data, $count)
    {

        $hotel = new Hotels();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewDeactivatedHotels");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">Deactivated Hotels</span>
        </div>
        <div class="mws-panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
            <thead>
            <tr>
                <th>Hotel Name</th>
                <th>Hotel Hits</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data) > 0) { ?>

                <?php
                for ($i = 0; $i < count($data); $i++) {
                    $hotel->extractor($data, $i);
                    $hotel_status = Libs::get("hotel_status_normal");
                    ?>
                    <tr id="row_<?php echo $hotel->hotelId(); ?>">
                        <td><?php echo $hotel->hotelName(); ?></td>
                        <td><?php echo $hotel->hotelHits(); ?></td>
                        <td>
                            <a onclick="activateHotel('<?php echo $hotel->hotelId(); ?>');" style="cursor:pointer; color: red;">Activate</a>
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

function viewTableSearch($data, $count, $search_str)
{

    $hotel = new Hotels();

    $paginations = new Paginations();
    $paginations->setLimit(10);
    $paginations->setPage($_REQUEST['page']);
    $paginations->setJSCallback("viewSearchedHotels");
    $paginations->setTotalPages($count);
    $paginations->makePaginationSearched($search_str);


    ?>
    <div class="mws-panel-header">
        <span class="mws-i-24 i-table-1">View Hotel</span>
    </div>
<div class="mws-panel-body">
    <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
        <thead>
        <tr>
            <th>Hotel Name</th>
            <th>Hotel Hits</th>
            <th>Active Status</th>
            <th>Featured Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($data) > 0) { ?>

            <?php
            for ($i = 0; $i < count($data); $i++) {
                $hotel->extractor($data, $i);
                $hotel_status = Libs::get("hotel_status_normal");
                ?>
                <tr id="row_<?php echo $hotel->hotelId(); ?>">
                    <td><?php echo $hotel->hotelName(); ?></td>
                    <td><?php echo $hotel->hotelHits(); ?></td>
                    <td>

                        <select id="hotels_status_<?php echo $hotel->hotelId(); ?>" onchange="hotelActiveStatus(<?php echo($hotel->hotelId()); ?>)">
                            <?php
                                foreach ($hotel_status as $key => $val) {
                                    ?>
                                    <option <?php if ($hotel->hotelActiveStatus() == $key) {
                                        echo 'selected="selected"';
                                    } ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                <?php
                                }
                            ?>
                        </select>

                    </td>
                    <td>

                        <select onchange="hotelsFeaturedStatus(<?php echo($hotel->hotelId()); ?>,<?php echo($hotel->hotelsFeaturedStatus()); ?>)">
                            <option <?php if ($hotel->hotelsFeaturedStatus() == 1) {
                                echo 'selected="selected"';
                            } ?> style="color:#469400;" value="1">Featured
                            </option>
                            <option <?php if ($hotel->hotelsFeaturedStatus() == 0) {
                                echo 'selected="selected"';
                            } ?> style="color:#900;" value="0">Not Featured
                            </option>
                        </select>

                    </td>
                    <td>
                        <a onclick="login_as_hotels('<?php echo $hotel->hotelId(); ?>');" style="cursor:pointer;">login as hotels</a> &nbsp; | &nbsp;
                        <?php if ($hotel->hotelActiveStatus() == Libs::getKey("hotel_status_normal", "Deactivation Pending")) { ?>
                            <a onclick="deleteHotel('<?php echo $hotel->hotelId(); ?>');" style="cursor:pointer; color: red;">Deactivate</a>
                        <?php } else { ?>
                            <a onclick="deleteHotel('<?php echo $hotel->hotelId(); ?>');" style="cursor:pointer;">Deactivate</a>
                        <?php } ?>
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

    function viewTableFront($data, $count)
    {
        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewHotelsFront");
        $paginations->setTotalPages($count);
        $paginations->makePagination();

        $mainCity = new MainCity();
        $hotels = new Hotels();
        $dicount_hotel = new Hotels();
        $country = new country();
        $SubCity = new SubCity();
        $hotelimages = new HotelImages();
        $discount = new HotelRoomRates();
        ?>
        <?php
        for ($x = 0; $x < count($data); $x++) {
            $dicount_hotel->extractor($data, $x);
            $discount->setHotelId($dicount_hotel->hotelId());
            $discount_data = $discount->getRatesFromHotelId();
            $discount->extractor($discount_data);

            if (round($discount->discountRatesUpLocal()) >= 0) {
                $new_hotel = new Hotels();
                $new_hotel->setHotelId($dicount_hotel->hotelId());
                $new_hotel_data = $new_hotel->getHotelFromId();
                $new_hotel->extractor($new_hotel_data);
                $hotelimages->setImageHotelId($new_hotel->hotelId());
                $hotelimages->extractor($hotelimages->getImageFromHotelsIdOne());
                $mainCity_discount = new MainCity();
                $mainCity_discount->setMainCityId($new_hotel->hotelMainCityId());
                $mainCity_discount->extractor($mainCity_discount->getMainCityFromId());
                $filename = '../../uploads/hotels/thumbnails/' . $hotelimages->imageName();
                ?>
                <div class="offer-listing">
                    <?php
                        if (file_exists($filename) && $hotelimages->imageName() != "") {
                            ?>
                            <img src="uploads/hotels/thumbnails/<?php echo $hotelimages->imageName(); ?>" width="157" height="130" alt="new_hotel"/>
                        <?php } else { ?>
                            <img src="images/no_image.jpg" alt="image" width="151" height="130"/>
                        <?php } ?>
                    <h4 onclick="makeAlert(<?php echo $new_hotel->hotelId(); ?>);" style="cursor:pointer;"><?php echo($new_hotel->hotelName()); ?></h4>
                    <input type="hidden" id="<?php echo $new_hotel->hotelId(); ?>" name="<?php echo $new_hotel->hotelId(); ?>" value="<?php echo $new_hotel->hotelSeoUrl(); ?>"/>
                    <h5><?php echo($mainCity_discount->mainCityName()); ?></h5>

                    <p><?php echo(substr($new_hotel->hotelDescription(), 0, 250)); ?></p>

                    <div class="price_tag">
                        <span class="striked_price"><!--Rs. 5,600--></span>
                        <span class="actual_price"><?php if ($discount->dblBbSellLocal()) {
                                echo('LKR ' . $discount->dblBbSellLocal());
                            } else {
                                echo('N/A');
                            } ?></span> <span class="label">Price Per Night</span>
                    </div>
                    <button onclick="makeAlert(<?php echo $new_hotel->hotelId(); ?>);">Book Now ></button>
                </div>
            <?php
            }
        } ?>
        <div id="pagination"><?php $paginations->drawPagination(); ?></div>
    <?php
    }

    function viewTableSpecialOfferHotels($data, $count)
    {
        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewSpecialOfferHotelsFront");
        $paginations->setTotalPages($count);
        $paginations->makePagination();

        $mainCity = new MainCity();
        $hotels = new Hotels();
        $country = new country();
        $SubCity = new SubCity();
        $hotelimages = new HotelImages();
        $discount = new HotelRoomRates();
        ?>
        <div class="after-mid">
            <div class="accordian-cont">
                <ul id="ulHotelList" class="hotelList">
                    <?php
                        for ($x = 0; $x < count($data); $x++) {
                            $hotels->extractor($data, $x);
                            $discount->setHotelId($hotels->hotelId());
                            $discount_data = $discount->getRatesFromHotelId();
                            $discount->extractor($discount_data);

                            $rateAvailable = $hotels->getLowestRate();
                            if ($rateAvailable['RateAvailable'] == true) {
                                $new_hotel = new Hotels();
                                $new_hotel->setHotelId($hotels->hotelId());
                                $new_hotel_data = $new_hotel->getHotelFromId();
                                $new_hotel->extractor($new_hotel_data);
                                $hotelimages->setImageHotelId($new_hotel->hotelId());
                                $hotelimages->extractor($hotelimages->getImageFromHotelsIdOne());
                                $mainCity_discount = new MainCity();
                                $mainCity_discount->setMainCityId($new_hotel->hotelMainCityId());
                                $mainCity_discount->extractor($mainCity_discount->getMainCityFromId());
                                $filename = DOC_ROOT . 'uploads/hotels/thumbnails/' . $hotelimages->imageName();
                                ?>
                                <li>
                                    <a href="<?php echo HTTP_PATH; ?><?php echo $new_hotel->hotelSeoUrl(); ?>.html">
                                        <?php
                                            if (file_exists($filename) && $hotelimages->imageName() != "") {
                                                ?>
                                                <img src="<?php echo HTTP_PATH . 'uploads/hotels/thumbnails/' . $hotelimages->imageName(); ?>" width="151" height="130" alt="new_hotel"/>
                                            <?php } else { ?>
                                                <img src="images/no_image.jpg" alt="image" width="151" height="130"/>
                                            <?php } ?>
                                        <div class="hotel-name-price">
                                            <h5 onclick="makeAlert(<?php echo $new_hotel->hotelId(); ?>);"><?php echo($new_hotel->hotelName()); ?></h5>
                                            <input type="hidden" id="<?php echo $new_hotel->hotelId(); ?>" name="<?php echo $new_hotel->hotelId(); ?>" value="<?php echo $new_hotel->hotelSeoUrl(); ?>"/>

                                        </div>
                                        <div>
                                            <span><?php echo $mainCity_discount->mainCityName(); ?></span>
                                        </div>
                                        <div class="price-box">
                                            <span>From</span>
                                            <span class="price">
                                                <?php echo $_SESSION['defaultCurrency'] . ' ' . $rateAvailable['Rate']; ?>
                                            </span>

                                            <p></p>
                                        </div>
                                    </a>
                                </li>

                            <?php
                            } ?>
                            <div id="pagination"><?php $paginations->drawPagination(); ?></div>
                        <?php
                        }?>
                </ul>
            </div>
        </div>
    <?php
    }
