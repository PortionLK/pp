<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewAccommodation":
            viewAccommodation();
            break;
        case "addAccommodation":
            addAccommodation();
            break;
        case "updateAccommodation":
            updateAccommodation();
            break;
        case "deleteAccommodation":
            deleteAccommodation();
            break;
    }

    function viewAccommodation()
    {
        $accommodation = new Accommodation();
        $data = $accommodation->getAllAccommodationPaginated($_REQUEST['page']);

        $count = $accommodation->getAllAccommodationCount();

        viewTable($data, $count[0]['count']);

    }

    function addAccommodation()
    {

        $accommodation = new Accommodation();

        $accommodation->setValues($_REQUEST);

        if ($accommodation->newAccommodation()) {
            Common::jsonSuccess("Accommodation Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateAccommodation()
    {

        $accommodation = new Accommodation();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $accommodation->setValues($get_edited);

        if ($accommodation->updateAccommodation()) {
            Common::jsonSuccess("Accommodation Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteAccommodation()
    {

        $accommodation = new Accommodation();
        $accommodation->setAccommodationId($_REQUEST['id']);

        if ($accommodation->deleteAccommodation()) {
            Common::jsonSuccess("Accommodation Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $accommodation = new Accommodation();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewAccommodation");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Accommodation</span>
        </div>
        <div class="mws-panel-body">
            <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
                <thead>
                <tr>
                    <th>Accommodation Name</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($data) > 0) { ?>

                    <?php
                    for ($i = 0; $i < count($data); $i++) {
                        $accommodation->extractor($data, $i);
                        ?>
                        <tr id="row_<?php echo $accommodation->accommodationId(); ?>">
                            <td><?php echo $accommodation->accommodationName(); ?></td>
                            <td class="center">
                                <a onclick="loadGUIContent('accommodation','edit','<?php echo $accommodation->accommodationId(); ?>')">Edit</a>
                                <a onclick="deleteAccommodation(<?php echo $accommodation->accommodationId(); ?>)"
                                   class="toggle">Delete</a>
                            </td>
                            <td></td>
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