<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "subscribe":
            subscribe();
            break;
        case "viewSubscribe":
            viewSubscribe();
            break;
        case "deleteSubscribe":
            deleteSubscribe();
            break;
    }

    function subscribe()
    {

        $subscribe = new Subscribe();

        $subscribe->setValues($_REQUEST);

        if ($subscribe->newSubscribe()) {
            Common::jsonSuccess("Subscribe Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewSubscribe()
    {

        $subscribe = new Subscribe();

        $data = $subscribe->getAllSubscribePaginated($_REQUEST['page']);

        $count = $subscribe->getAllSubscribeCount();

        viewTable($data, $count[0]['count']);

    }

    function deleteSubscribe()
    {

        $subscribe = new Subscribe();
        $subscribe ->setId($_REQUEST['id']);
        $subscribe ->deleteSubscribe();

    }

    function viewTable($data, $count)
    {

        $subscribe = new Subscribe();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewSubscribe");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Subscribe</span>
        </div>
        <div class="mws-panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
            <thead>
            <tr>
                <th>Subscribe Email Address</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($data as $sdtata) { ?>

                <tr id="row_<?php echo $sdtata['id']; ?>">

                    <td><?php echo $sdtata['email']; ?></td>

                    <td>
                        <a onclick="deleteSubscribe(<?php echo $sdtata['id']; ?>);" style="cursor:pointer;">Delete This
                            Email Address</a>
                    </td>

                </tr>

            <?php } ?>

            </tbody>
        </table>

        <?php
        $paginations->drawPagination();
    }

?>