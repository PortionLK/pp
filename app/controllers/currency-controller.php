<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewCurrencys":
            viewCurrencys();
            break;
        case "addCurrency":
            addCurrency();
            break;
        case "updateCurrency":
            updateCurrency();
            break;
        case "deleteCurrency":
            deleteCurrency();
            break;
    }

    function viewCurrencys()
    {
        $currency = new Currency();
        $data = $currency->getAllCurrencyPaginated($_REQUEST['page']);

        $count = $currency->getAllCurrencyCount();

        viewTable($data, $count[0]['count']);

    }

    function addCurrency()
    {

        $admin = new Currency();

        $admin->setValues($_REQUEST);

        if ($admin->newCurrency()) {
            Common::jsonSuccess("Currency Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateCurrency()
    {

        $currency = new Currency();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $currency->setValues($get_edited);

        if ($currency->updateCurrency()) {
            Common::jsonSuccess("Currency Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteCurrency()
    {

        $currency = new Currency();
        $currency->setCurrId($_REQUEST['id']);

        if ($currency->deleteCurrency()) {
            Common::jsonSuccess("Currency Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $currency = new Currency();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewCurrencys");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Currency</span>
        </div>
        <div class="mws-panel-body">
            <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
                <colgroup>
                    <col class="con0"/>
                    <col class="con1"/>
                </colgroup>
                <thead>
                <tr>
                    <th class="head1">Currency Code</th>
                    <th class="head0">Currency Perfix</th>
                    <th class="head0">Currency Suffix</th>
                    <th class="head1">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($data) > 0) { ?>

                    <?php
                    for ($i = 0; $i < count($data); $i++) {
                        $currency->extractor($data, $i);
                        ?>
                        <tr id="row_<?php echo $currency->currId(); ?>">
                            <td class="con1"><?php echo $currency->currCode(); ?></td>
                            <td class="con0"><?php echo $currency->currPrefix(); ?></td>
                            <td class="con0"><?php echo $currency->currSuffix(); ?></td>
                            <td class="center">
                                <a onclick="loadGUIContent('currency','edit','<?php echo $currency->currId(); ?>')">Edit</a>
                                <a onclick="deleteCurrency(<?php echo $currency->currId(); ?>)"
                                   class="toggle">Delete</a>
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