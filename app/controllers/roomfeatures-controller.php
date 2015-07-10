<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewRoomFeatures":
            viewRoomFeatures();
            break;
        case "addRoomFeatures":
            addRoomFeatures();
            break;
        case "updateRoomFeatures":
            updateRoomFeatures();
            break;
        case "deleteRoomFeatures":
            deleteRoomFeatures();
            break;
    }

    function viewRoomFeatures()
    {
        $room_features = new RoomFeatures();
        $data = $room_features->getAllRoomFeaturesPaginated($_REQUEST['page']);

        $count = $room_features->getAllRoomFeaturesCount();

        viewTable($data, $count[0]['count']);

    }

    function addRoomFeatures()
    {

        $room_features = new RoomFeatures();

        $room_features->setValues($_REQUEST);

        if ($room_features->newRoomFeatures()) {
            Common::jsonSuccess("Room Features Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateRoomFeatures()
    {

        $room_features = new RoomFeatures();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $room_features->setValues($get_edited);

        if ($room_features->updateRoomFeatures()) {
            Common::jsonSuccess("Room Features Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteRoomFeatures()
    {

        $room_features = new RoomFeatures();
        $room_features->setRoomFeatureId($_REQUEST['id']);

        if ($room_features->deleteRoomFeatures()) {
            Common::jsonSuccess("Room Features Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $room_features = new RoomFeatures();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewRoomFeatures");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Room Features</span>
        </div>
        <div class="mws-panel-body">
            <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
                <colgroup>
                    <col class="con0"/>
                    <col class="con1"/>
                </colgroup>
                <thead>
                <tr>
                    <th class="head1">Name</th>
                    <th class="head0">&nbsp;</th>
                    <th class="head0">&nbsp;</th>
                    <th class="head1">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($data) > 0) { ?>

                    <?php
                    for ($i = 0; $i < count($data); $i++) {
                        $room_features->extractor($data, $i);
                        ?>
                        <tr id="row_<?php echo $room_features->roomFeatureId(); ?>">
                            <td class="con1"><?php echo $room_features->roomFeatureName(); ?></td>
                            <td class="con0"><?php //echo $room_features->roomFeatureName(); ?></td>
                            <td class="con0"><?php //echo $room_features->username(); ?></td>
                            <td class="center">
                                <a onclick="loadGUIContent('roomfeatures','edit','<?php echo $room_features->roomFeatureId(); ?>')">Edit</a>
                                <a onclick="deleteRoomFeatures(<?php echo $room_features->roomFeatureId(); ?>)"
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

?>