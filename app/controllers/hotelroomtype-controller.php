<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewHotelRoomTypes":
            viewHotelRoomTypes();
            break;
        case "addHotelRoomType":
            addHotelRoomType();
            break;
        case "updateHotelFetursType":
            updateHotelFetursType();
            break;
        case "deleteHotelRoomType":
            deleteHotelRoomType();
            break;
        case "checkForCalendar":
            checkForCalendar();
            break;
        case "getIfCheckInOutAvailableForHotelForDate":
            getIfCheckInOutAvailableForHotelForDate();
            break;
        case "getHotelRoomTypeFromId":
            getHotelRoomTypeFromId();
            break;
        case "roomControlDeleteById":
            roomControlDeleteById();
            break;
        case "removeRoomImage":
            removeRoomImage();
            break;
    }

    function getHotelRoomTypeFromId()
    {

        $roomcontrol = new RoomControl();
        $data = $roomcontrol ->getAllRoomsFromRoomTypeID($_REQUEST['roomTypeId']);
        $hotel_room_type = new HotelRoomType();
        $hotel_room_type ->setRoomTypeId($_REQUEST['roomTypeId']);
        $result = $hotel_room_type ->getHotelRoomTypeFromId();

        $data2[1] = array(
            'rc_num_of_rooms' => '',
            'rc_in_date'      => '',
            'rc_out_date'     => ''
        );
        if (!empty($data))
            $result_s = array_merge($result, $data);
        else
            $result_s = array_merge($result, $data2);
        echo json_encode($result_s);
    }

    function viewHotelRoomTypes()
    {

        $hotel_room_type = new HotelRoomType();

        $data = $hotel_room_type->getAllHotelRoomTypePaginated($_REQUEST['page']);

        $count = $hotel_room_type->getAllHotelRoomTypeCount();

        viewTable($data, $count[0]['count']);

    }

    function addHotelRoomType()
    {

        $admin = new HotelRoomType();

        $admin->setValues($_REQUEST);

        if ($admin->newHotelRoomType()) {
            Common::jsonSuccess("Hotel Room Type Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateHotelFetursType()
    {

        $admin = new HotelRoomType();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $admin->setValues($get_edited);
        if ($admin->updateHotelRoomType()) {
            Common::jsonSuccess("Hotel Room Type Update Successfully!");
        } else {
            Common::jsonError("Error");
        }
    }

    function deleteHotelRoomType()
    {
        $roomtype = new HotelRoomType();
        $roomtype->setRoomTypeId($_REQUEST['id']);
        if ($roomtype->deleteHotelRoomType()) {
            Common::jsonSuccess("Hotel Room Type Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }
    }

    function roomControlDeleteById()
    {
        $roomControl = new RoomControl();
        $roomControl->setRcId($_REQUEST['id']);
        if ($roomControl->removeRoomControlById()) {
            Common::jsonSuccess("Room Assignment Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }
    }

    function viewTable($data, $count)
    {

        $hotel_room_type = new HotelRoomType();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewHotelRoomTypes");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Hotel Room Type</span>
        </div>
        <div class="mws-panel-body">
            <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
                <colgroup>
                    <col class="con0"/>
                    <col class="con1"/>
                </colgroup>
                <thead>
                <tr>
                    <th class="head1">Room Type Name</th>
                    <th class="head0">&nbsp;</th>
                    <th class="head0">&nbsp;</th>
                    <th class="head1">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($data) > 0) { ?>

                    <?php
                    for ($i = 0; $i < count($data); $i++) {
                        $hotel_room_type->extractor($data, $i);
                        ?>
                        <tr id="row_<?php echo $hotel_room_type->roomTypeId(); ?>">
                            <td class="con1"><?php echo $hotel_room_type->roomTypeName(); ?></td>
                            <td class="con0"><?php //echo $hotel_room_type->categorySeoName(); ?></td>
                            <td class="con0"><?php //echo $hotel_room_type->username(); ?></td>
                            <td class="center"><a
                                    onclick="loadGUIContent('hotelroomtype','edit','<?php echo $hotel_room_type->roomTypeId(); ?>')">Edit</a>
                                <a onclick="deleteHotelRoomType(<?php echo $hotel_room_type->roomTypeId(); ?>)"
                                   class="toggle">Delete</a></td>
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

    function checkForCalendar()
    {
        $roomControl=new RoomControl();
        $not_available_dates = array();
        $maxDate=$roomControl->getMaxAvailableDate($_REQUEST['hotel_id']);

        $rc_in_date = date("Y-m-d", time());;
        $rc_out_date = date("Y-m-d", strtotime("+12 months"));
        if(count($maxDate)>0) {
            if($maxDate[0]['maxDate']<>"") {
                $rc_out_date = date("Y-m-d", strtotime($maxDate[0]['maxDate']));
            }
        }

        foreach (Common::createDateRangeArray($rc_in_date, $rc_out_date) as $k => $v) {
            $roomData = $roomControl->getAvailableRoomCountForHotelForDate($v,$_REQUEST['hotel_id']);
            $assignedRooms=$roomControl->getAssignedRoomCountForHotelForDate($v,$_REQUEST['hotel_id']);
            $checkInCheckOut=$roomControl->getIfCheckInOutAvailableForHotelForDate($v,$_REQUEST['hotel_id']);

            if(count($assignedRooms)>0){
                if($assignedRooms[0]['num_of_rooms']>0){
                    $assignedRooms=$assignedRooms[0]['num_of_rooms'];
                }else{
                    $assignedRooms=0;
                }
            }else{
                $assignedRooms=0;
            }

            if(count($checkInCheckOut)>0){
                if($checkInCheckOut[0]['reservation_count']>1){
                    if(($checkInCheckOut[0]['reserved_rooms']/$checkInCheckOut[0]['reservation_count'])<$assignedRooms){
                        $checkInCheckOut=false;
                    }else{
                        $checkInCheckOut=true;
                    }
                }else{
                    $checkInCheckOut=false;
                }
            }else{
                $checkInCheckOut=false;
            }
            if(count($roomData)>0){
                if($roomData[0]['available_rooms']>0){
                    //array_push($not_available_dates, $v);
                    $not_available_dates[$v]=$checkInCheckOut;
                }
            }
        }
        echo json_encode($not_available_dates);
    }

    function removeRoomImage()
    {
        $file = $_REQUEST['image'];
        $file_path = DOC_ROOT . 'uploads/room-gal/' . $file;

        if (file_exists($file_path)) {
            if (unlink($file_path)) {
                Common::jsonSuccess("Room Image Deleted Successfully");
            } else {
                Common::jsonError("Failed To Delete");
            }
        } else {
            Common::jsonError("Error");
        }
    }
?>