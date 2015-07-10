<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewHotelFetursType":
            viewHotelFetursType();
            break;
        case "addHotelFetursType":
            addHotelFetursType();
            break;
        case "updateHotelFetursType":
            updateHotelFetursType();
            break;
        case "deleteHotelFetursType":
            deleteHotelFetursType();
            break;
    }

    function viewHotelFetursType()
    {

        $hotelfeat_type = new HotelFetursType();

        $data = $hotelfeat_type->getAllHotelFeatureTypePaginated($_REQUEST['page']);

        $count = $hotelfeat_type->getAllHotelFeatureTypeCount();

        viewTable($data, $count[0]['count']);

    }

    function addHotelFetursType()
    {

        $hotelfeat_type = new HotelFetursType();

        $hotelfeat_type->setValues($_REQUEST);

        if ($hotelfeat_type->newHotelFeatureType()) {
            Common::jsonSuccess("Feturs Type Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateHotelFetursType()
    {

        $hotelfeat_type = new HotelFetursType();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $hotelfeat_type->setValues($get_edited);

        if ($hotelfeat_type->updateHotelFeatureType()) {
            Common::jsonSuccess("Featurs Type Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteHotelFetursType()
    {

        $hotelfeat_type = new HotelFetursType();
        $hotelfeat_type->setHotelFeatureTypeId($_REQUEST['id']);
        if ($hotelfeat_type->deleteHotelFeatureType()) {
            Common::jsonSuccess("Feturs Type Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $hotelfeat_type = new HotelFetursType();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewHotelFetursType");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Hotel Feature Type</span>
        </div>
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
                        $hotelfeat_type->extractor($data, $i);
                        ?>
                        <tr id="row_<?php echo $hotelfeat_type->hotelFeatureTypeId(); ?>">
                            <td><?php echo $hotelfeat_type->hotelFeatureTypeName(); ?></td>
                            <td><?php //echo $hotelfeat_type->categorySeoName(); ?></td>
                            <td class="center">
                                <a onclick="loadGUIContent('hotelfeturstype','edit','<?php echo $hotelfeat_type->hotelFeatureTypeId(); ?>')">Edit</a>
                                <a onclick="deleteHotelFetursType(<?php echo $hotelfeat_type->hotelFeatureTypeId(); ?>)"
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