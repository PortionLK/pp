<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewNews":
            viewNews();
            break;
        case "addNews":
            addNews();
            break;
        case "updateNews":
            updateNews();
            break;
        case "deleteMainCity":
            deleteMainCity();
            break;
        case "updateMainCityImages";
            updateMainCityImages();
            break;
        case "deleteNews";
            deleteNews();
            break;
        case "viewNewsFront";
            viewNewsFront();
            break;

    }


    function viewNews()
    {
        $news = new News();

        $data = $news->getAllNewsPaginated($_REQUEST['page']);

        $count = $news->getAllNewsCount();

        viewTable($data, $count[0]['count']);

    }


    function viewNewsFront()
    {
        $news = new News();

        $data = $news->getAllNewsPaginatedFront($_REQUEST['page']);

        $count = $news->getAllNewsCountFront();

        viewTableFront($data, $count[0]['count']);

    }


    function addNews()
    {
        $news = new News();
        $news->setValues($_REQUEST);
        if ($news->newNews()) {
            //$session = new Sessions();
            //$session->setLastMainCityId(mysql_insert_id());
            Common::jsonSuccess("News Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }


    function updateNews()
    {

        $news = new News();
        $news->id($_REQUEST['id']);

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $news->setValues($get_edited);

        if ($news->updateNews()) {
            Common::jsonSuccess("News Update Successfully!");
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

    function deleteNews()
    {

        $news = new News();
        $admin->setId($_REQUEST['id']);

        if ($news->deleteNews()) {
            Common::jsonSuccess("News Deleted Successfully");
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

    $news = new News();

    $paginations = new Paginations();
    $paginations->setLimit(10);
    $paginations->setPage($_REQUEST['page']);
    $paginations->setJSCallback("viewNews");
    $paginations->setTotalPages($count);
    $paginations->makePagination();


?>
    <div class="mws-panel-header">
        <span class="mws-i-24 i-table-1">View News</span>
    </div>
<div class="mws-panel-body">
    <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
        <colgroup>
            <col class="con0"/>
            <col class="con1"/>
        </colgroup>
        <thead>
        <tr>
            <th class="head1">News Title</th>
            <th class="head0">&nbsp;</th>
            <th class="head0">&nbsp;</th>
            <th class="head1">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($data) > 0) { ?>

            <?php
            for ($i = 0; $i < count($data); $i++) {
                $news->extractor($data, $i);
                ?>
                <tr id="row_<?php echo $news->id(); ?>">
                    <td class="con1"><?php echo $news->title(); ?></td>
                    <td class="con0"><?php //echo $news->image(); ?></td>
                    <td class="con0"><?php //echo $admins->username(); ?></td>
                    <td class="center"><a onclick="loadGUIContent('news','edit','<?php echo $news->id(); ?>')">Edit</a>
                        <a onclick="deleteNews(<?php echo $news->id(); ?>)" class="toggle">Delete</a></td>
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

<?php
    function viewTableFront($data, $count){

    $news = new News();

    $paginations = new Paginations();
    $paginations->setLimit(10);
    $paginations->setPage($_REQUEST['page']);
    $paginations->setJSCallback("viewNewsFront");
    $paginations->setTotalPages($count);
    $paginations->makePagination();


?>

<?php for ($k = 0; $k < count($data); $k++) {
    $news->extractor($data, $k); ?>
    <div class="event-display-box-r">
        <div class="event-box-txt-r">
            <h3><span class="tour-box-title-col"><?php echo($news->title()); ?></span></h3>
            <span class="event-date"><!--Duration Period From 2013-12-01 To 2013-04-30--></span>

            <p>
                <?php echo($news->body()); ?></p>
            <!--<div class="tour-box-more"><a href="">+ more</a></div>-->
        </div>
        <div class="tour-box-image"><img src="<?php HTTP_PATH ?>uploads/news/<?php echo($news->image()); ?>" width="150"
                                         height="110"/></div>
        <div style="clear:both"></div>
    </div>
<?php } ?>

<div id="pagination">
    <?php $paginations->drawPagination();
        } ?></div>