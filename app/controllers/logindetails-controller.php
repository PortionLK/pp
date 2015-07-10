<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewLoginDetails":
            viewLoginDetails();
            break;
        case "addLoginDetails":
            addLoginDetails();
            break;
        case "updateCategory":
            updateCategory();
            break;
        case "deleteCategory":
            deleteCategory();
            break;
    }

    function viewLoginDetails()
    {
        $login_details = new LoginDetails();
        $data = $login_details->getAllLoginDetailsPaginated($_REQUEST['page']);

        $count = $login_details->getAllLoginDetailsCount();

        viewTable($data, $count[0]['count']);

    }

    function addLoginDetails()
    {

        $admin = new LoginDetails();

        $admin->setValues($_REQUEST);

        if ($admin->newLoginDetails()) {
            Common::jsonSuccess("Login Details Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateLoginDetails()
    {

        $admin = new LoginDetails();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $admin->setValues($get_edited);

        if ($admin->updateLoginDetails()) {
            Common::jsonSuccess("Login Details Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteLoginDetails()
    {

        $admin = new LoginDetails();
        $admin->setUId($_REQUEST['id']);

        if ($admin->deleteLoginDetails()) {
            Common::jsonSuccess("Login Details Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $login_details = new LoginDetails();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewLoginDetails");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>

        <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablequick">
            <colgroup>
                <col class="con0"/>
                <col class="con1"/>
            </colgroup>
            <thead>
            <tr>
                <th class="head1">ID</th>
                <th class="head0">IP</th>
                <th class="head0">Last Login</th>
                <th class="head1">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data) > 0) { ?>

                <?php
                for ($i = 0; $i < count($data); $i++) {
                    $login_details->extractor($data, $i);
                    ?>
                    <tr id="row_<?php echo $login_details->uId(); ?>">
                        <td class="con1"><?php echo $login_details->uLId(); ?></td>
                        <td class="con0"><?php echo $login_details->uLIp(); ?></td>
                        <td class="con0"><?php echo $login_details->uLIntime(); ?></td>
                        <td class="center"><a href="category.php?id=<?php echo $login_details->uId(); ?>">Edit</a> | <a
                                href="javascript:;" onclick="deleteCategory(<?php echo $login_details->uId(); ?>)"
                                class="toggle">Delete</a></td>
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

?>