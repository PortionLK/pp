<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewAdministrators":
            viewAdministrators();
            break;
        case "addAdministrator":
            addAdministrator();
            break;
        case "updateAdministrator":
            updateAdministrator();
            break;
        case "deleteAdministrator":
            deleteAdministrator();
            break;
    }

    function viewAdministrators()
    {

        $admins = new Administrators();
        $data = $admins->getAllAdminsPaginated($_REQUEST['page']);

        $count = $admins->getAllAdminsCount();

        viewTable($data, $count[0]['count']);

    }

    function addAdministrator()
    {

        $admin = new Administrators();

        $admin->setValues($_REQUEST);

        if ($admin->newAdministrator()) {
            Common::jsonSuccess("Administrator Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateAdministrator()
    {

        $admin = new Administrators();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $admin->setValues($get_edited);

        if ($admin->updateAdministrator()) {
            Common::jsonSuccess("Administrator Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteAdministrator()
    {

        $admin = new Administrators();
        $admin->setId($_REQUEST['id']);

        if ($admin->deleteAdministrator()) {
            Common::jsonSuccess("Adminstrators Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $admins = new Administrators();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewAdministrators");
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
                <th class="head1">Name</th>
                <th class="head0">Email</th>
                <th class="head0">Username</th>
                <th class="head1">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data) > 0) { ?>

                <?php
                for ($i = 0; $i < count($data); $i++) {
                    $admins->extractor($data, $i);
                    ?>
                    <tr id="row_<?php echo $admins->id(); ?>">
                        <td class="con1"><?php echo $admins->name(); ?></td>
                        <td class="con0"><?php echo $admins->email(); ?></td>
                        <td class="con0"><?php echo $admins->username(); ?></td>
                        <td class="center"><a href="administrator.php?id=<?php echo $admins->id(); ?>">Edit</a> | <a
                                href="javascript:;" onclick="deleteAdministrator(<?php echo $admins->id(); ?>)"
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