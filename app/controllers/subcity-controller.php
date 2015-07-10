<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];
    switch ($action) {

        case "viewSubCity":
            viewSubCity();
            break;
        case "addSubCity":
            addSubCity();
            break;
        case "updateSubCity":
            updateSubCity();
            break;
        case "deleteSubCity":
            deleteSubCity();
            break;
        case "getSubCityByMainID":
            getSubCityByMainID();
            break;
        case "getSubCityByMainIDSelect":
            getSubCityByMainIDSelect();
            break;
        case "updateSubCityImages";
            updateSubCityImages();
            break;
        case "deleteSubCityImage";
            deleteSubCityImage();
            break;

    }

    function viewSubCity()
    {
        $sub_city = new SubCity();
        $data = $sub_city->getAllSubCityPaginated($_REQUEST['page']);

        $count = $sub_city->getAllSubCityCount();

        viewTable($data, $count[0]['count']);

    }

    function addSubCity()
    {

        $sub_city = new SubCity();

        $sub_city->setValues($_REQUEST);

        if ($sub_city->newSubCity()) {
            $session = new Sessions();
            $session->setLastSubCityId(mysql_insert_id());
            Common::jsonSuccess("Sub City Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateSubCity()
    {

        $sub_city = new SubCity();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $sub_city->setValues($get_edited);

        if ($sub_city->updateSubCity()) {
            Common::jsonSuccess("Sub City Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateSubCityImages()
    {

        $subcity = new SubCity();
        $session = new Sessions();

        $subcity->setSubCityId($session->getLastSubCityId());

        $data = $subcity->getSubCityFromId();
        $subcity->extractor($data);
        $imgs = $subcity->subCityImage();
        if ($imgs != "") {
            $imgs = $imgs . ',' . $_REQUEST['images'];
        } else {
            $imgs = $_REQUEST['images'];
        }
        $subcity->setSubCityImage($imgs);

        if ($subcity->updateSubCityImages()) {
            Common::jsonSuccess("Sub City Update Successfully!");
        } else {
            Common::jsonError("Error");
        }
    }

    function deleteSubCity()
    {

        $sub_city = new SubCity();
        $sub_city->setSubCityId($_REQUEST['id']);

        if ($sub_city->deleteSubCity()) {
            Common::jsonSuccess("Category Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function getSubCityByMainID()
    {
        $sub_city = new SubCity();
        $sub_city->setSubCityMainId($_REQUEST['id']);
        $sub_city_rows = $sub_city->getSubCityByMainID();

        ?>
        <select name="hotel_sub_city_id" id="hotel_sub_city_id" class="send_data">
            <option value="">Select Your Sub City</option><?php
                for ($p = 0; $p < count($sub_city_rows); $p++) {
                    $sub_city->extractor($sub_city_rows, $p);?>
                    <option
                        value="<?php echo $sub_city->subCityId(); ?>"><?php echo $sub_city->subCityName(); ?> </option>
                <?php } ?>
        </select>
    <?php
    }

    function getSubCityByMainIDSelect()
    {
        $sub_city = new SubCity();
        $sub_city->setSubCityMainId($_REQUEST['id']);
        $sub_city_rows = $sub_city->getSubCityByMainID();

        ?>
        <select name="hotel_sub_city_id" id="hotel_sub_city_id" class="send_data">
            <option value="">Select Your Sub City</option><?php
                for ($p = 0; $p < count($sub_city_rows); $p++) {
                    $sub_city->extractor($sub_city_rows, $p);?>
                    <option
                        value="<?php echo $sub_city->subCityId(); ?>" <?php if ($_REQUEST['subid'] == $sub_city->subCityId()) {
                        echo('selected="selected"');
                    } ?> ><?php echo $sub_city->subCityName(); ?> </option>
                <?php } ?>
        </select>
    <?php
    }

    function deleteSubCityImage()
    {
        $file = $_REQUEST['image'];
        $file_path = DOC_ROOT . 'uploads/sub-city/' . $file;

        if (file_exists($file_path)) {

            if (unlink($file_path)) {

                $subcity = new SubCity();
                $subcity->setSubCityId($_REQUEST['id']);
                $data = $subcity->getSubCityFromId();
                $subcity->extractor($data);
                $imagelist = $subcity->subCityImage();
                $imgs = explode(',', $imagelist);

                $key = array_search($file, $imgs);
                if (false !== $key) {
                    unset($imgs[$key]);
                }

                for ($x = 0; $x <= count($imgs); $x++) {
                    if (!empty($imgs[$x])) {
                        $update_img .= $imgs[$x] . ',';
                    }
                }

                $subcity->setSubCityImage($update_img);
                $subcity->updateSubCityImages();

                Common::jsonSuccess("City Image Deleted Successfully");
            } else {
                Common::jsonError("Fail To Delete");
            }
        } else {
            Common::jsonError("Error");
        }
    }

    function viewTable($data, $count)
    {

        $sub_city = new SubCity();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewSubCity");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Sub City</span>
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
                    <th class="head0">Geo Location</th>
                    <th class="head0">&nbsp;</th>
                    <th class="head1">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($data) > 0) { ?>

                    <?php
                    for ($i = 0; $i < count($data); $i++) {
                        $sub_city->extractor($data, $i);
                        ?>
                        <tr id="row_<?php echo $sub_city->subCityId(); ?>">
                            <td class="con1"><?php echo $sub_city->subCityName(); ?></td>
                            <td class="con0"><?php echo $sub_city->subCityGeoLocation(); ?></td>
                            <td class="con0"><?php //echo $sub_city->username(); ?></td>
                            <td class="center"><a
                                    onclick="loadGUIContent('subcity','edit','<?php echo $sub_city->subCityId(); ?>')">Edit</a>
                                <a href="javascript:;" onclick="deleteSubCity(<?php echo $sub_city->subCityId(); ?>)"
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