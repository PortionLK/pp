<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewHotelFetursList":
            viewHotelFetursList();
            break;
        case "addHotelFetursList":
            addHotelFetursList();
            break;
        case "updateHotelFetursList":
            updateHotelFetursList();
            break;
        case "deleteHotelFetursList":
            deleteHotelFetursList();
            break;
    }

    function viewHotelFetursList()
    {

        $hotelfeatureslist = new HotelFetursList();

        $data = $hotelfeatureslist->getAllHotelFeatureListPaginated($_REQUEST['page']);

        $count = $hotelfeatureslist->getAllHotelFeatureListCount();

        viewTable($data, $count[0]['count']);

    }

    function addHotelFetursList()
    {

        $hotelfeatureslist = new HotelFetursList();

        $hotelfeatureslist->setValues($_REQUEST);

        if ($hotelfeatureslist->newHotelFeatureList()) {
            Common::jsonSuccess("Hotel Features List Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateHotelFetursList()
    {

        $hotelfeatureslist = new HotelFetursList();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $hotelfeatureslist->setValues($get_edited);

        if ($hotelfeatureslist->updateHotelFeatureList()) {
            Common::jsonSuccess("Hotel Features List Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteHotelFetursList()
    {

        $hotelfeatureslist = new HotelFetursList();
        $hotelfeatureslist->setHotelFeatureListId($_REQUEST['id']);

        if ($hotelfeatureslist->deleteHotelFeatureList()) {
            Common::jsonSuccess("Hotel Features List Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $hotelfeatureslist = new HotelFetursList();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewHotelFetursList");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Hotel Feature List</span>
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
                        $hotelfeatureslist->extractor($data, $i);
                        ?>
                        <tr id="row_<?php echo $hotelfeatureslist->hotelFeatureListId(); ?>">
                            <td class="con1"><?php echo $hotelfeatureslist->hotelFeatureListName(); ?></td>
                            <td class="con0"><?php //echo $hotelfeatureslist->categorySeoName(); ?></td>
                            <td class="con0"><?php //echo $hotelfeatureslist->username(); ?></td>
                            <td class="center">
                                <a onclick="loadGUIContent('hotelfeturslist','edit','<?php echo $hotelfeatureslist->hotelFeatureListId(); ?>')">Edit</a>
                                <a onclick="deleteHotelFetursList(<?php echo $hotelfeatureslist->hotelFeatureListId(); ?>)"
                                   class="toggle">Delete</a></td>
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

?>