<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewMainCitys":
            viewMainCitys();
            break;
        case "addMainCity":
            addMainCity();
            break;
        case "updateMainCity":
            updateMainCity();
            break;
        case "deleteMainCity":
            deleteMainCity();
            break;
        case "updateMainCityImages";
            updateMainCityImages();
            break;
        case "deleteMainCityImage";
            deleteMainCityImage();
            break;

    }


    function viewMainCitys()
    {
        $maincity = new MainCity();

        $data = $maincity->getAllMainCityPaginated($_REQUEST['page']);

        $count = $maincity->getAllMainCityCount();

        viewTable($data, $count[0]['count']);

    }

    function addMainCity()
    {

        $maincity = new MainCity();
        $maincity->setValues($_REQUEST);

        if ($maincity->newMainCity()) {
            $session = new Sessions();
            $session->setLastMainCityId(mysql_insert_id());
            Common::jsonSuccess("Main City Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }


    function updateMainCity()
    {

        $maincity = new MainCity();
        $maincity->setMainCityId($_REQUEST['id']);

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $maincity->setValues($get_edited);

        if ($maincity->updateMainCity()) {
            Common::jsonSuccess("Main City Update Successfully!");
        } else {
            Common::jsonError("Error");
        }
    }

    function updateMainCityImages()
    {

        $maincity = new MainCity();
        $session = new Sessions();

        $maincity->setMainCityId($session->getLastMainCityId());

        $data = $maincity->getMainCityFromId();
        $maincity->extractor($data);
        $imgs = $maincity->mainCityImage();
        if ($imgs != "") {
            $imgs = $imgs . ',' . $_REQUEST['images'];
        } else {
            $imgs = $_REQUEST['images'];
        }
        $maincity->setMainCityImage($imgs);

        if ($maincity->updateMainCityImages()) {
            Common::jsonSuccess("Main City Update Successfully!");
        } else {
            Common::jsonError("Error");
        }
    }

    function deleteMainCity()
    {

        $admin = new MainCity();
        $admin->setMainCityId($_REQUEST['id']);

        if ($admin->deleteMainCity()) {
            Common::jsonSuccess("Main City Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteMainCityImage()
    {
        $file = $_REQUEST['image'];
        $file_path = DOC_ROOT . 'uploads/main-city/' . $file;

        if (file_exists($file_path)) {

            if (unlink($file_path)) {

                $maincity = new MainCity();
                $maincity->setMainCityId($_REQUEST['id']);
                $data = $maincity->getMainCityFromId();
                $maincity->extractor($data);
                $imagelist = $maincity->mainCityImage();
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

                $maincity->setMainCityImage($update_img);
                $maincity->updateMainCityImages();

                Common::jsonSuccess("City Image Deleted Successfully");
            } else {
                Common::jsonError("Fail To Delete");
            }
        } else {
            Common::jsonError("Error");
        }
    }

    function viewTable($data, $count){

    $maincity = new MainCity();

    $paginations = new Paginations();
    $paginations->setLimit(10);
    $paginations->setPage($_REQUEST['page']);
    $paginations->setJSCallback("viewMainCitys");
    $paginations->setTotalPages($count);
    $paginations->makePagination();


?>
<div class="mws-panel-header">
    <span class="mws-i-24 i-table-1">View Main City</span>
</div>
<div class="mws-panel-body">
    <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
        <colgroup>
            <col class="con0"/>
            <col class="con1"/>
        </colgroup>
        <thead>
        <tr>
            <th class="head1">Main City Name</th>
            <th class="head0">Main City SEO</th>
            <th class="head0">&nbsp;</th>
            <th class="head1">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($data) > 0) { ?>

            <?php
            for ($i = 0; $i < count($data); $i++) {
                $maincity->extractor($data, $i);
                ?>
                <tr id="row_<?php echo $maincity->mainCityId(); ?>">
                    <td class="con1"><?php echo $maincity->mainCityName(); ?></td>
                    <td class="con0"><?php echo $maincity->mainCitySeo(); ?></td>
                    <td class="con0"><?php //echo $admins->username(); ?></td>
                    <td class="center"><a
                            onclick="loadGUIContent('maincity','edit','<?php echo $maincity->mainCityId(); ?>')">Edit</a>
                        <a onclick="deleteMainCity(<?php echo $maincity->mainCityId(); ?>)" class="toggle">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>

        <?php } ?>
        </tbody>
    </table>
    <?php $paginations->drawPagination();
        } ?>
</div>