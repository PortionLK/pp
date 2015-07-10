<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewMemberBankDetails":
            viewMemberBankDetails();
            break;
        case "addMemberBankDetail":
            addMemberBankDetail();
            break;
        case "updateCategory":
            updateCategory();
            break;
        case "deleteCategory":
            deleteCategory();
            break;
    }

    function viewMemberBankDetails()
    {
        $member_bank_details = new MemberBankDetails();

        $data = $member_bank_details->getAllMemberBankDetailsPaginated($_REQUEST['page']);

        $count = $member_bank_details->getAllMemberBankDetailsCount();

        viewTable($data, $count[0]['count']);

    }

    function addMemberBankDetail()
    {

        $member_bank_details = new MemberBankDetails();

        $member_bank_details->setValues($_REQUEST);

        if ($member_bank_details->newMemberBankDetails()) {
            Common::jsonSuccess("Member Bank Details Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateMemberBankDetail()
    {

        $member_bank_details = new MemberBankDetails();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $member_bank_details->setValues($get_edited);

        if ($member_bank_details->updateMemberBankDetails()) {
            Common::jsonSuccess("Member Bank Details Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteMemberBankDetail()
    {

        $member_bank_details = new MemberBankDetails();
        $member_bank_details->setBankId($_REQUEST['id']);

        if ($member_bank_details->deleteMemberBankDetails()) {
            Common::jsonSuccess("Member Bank Details Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $member_bank_details = new MemberBankDetails();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewMemberBankDetails");
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
                    $member_bank_details->extractor($data, $i);
                    ?>
                    <tr id="row_<?php echo $member_bank_details->bankId(); ?>">
                        <td class="con1"><?php echo $member_bank_details->bankName(); ?></td>
                        <td class="con0"><?php echo $member_bank_details->bankBranch(); ?></td>
                        <td class="con0"><?php echo $member_bank_details->bankAccountNumber(); ?></td>
                        <td class="center"><a
                                href="category.php?id=<?php echo $member_bank_details->bankId(); ?>">Edit</a> | <a
                                href="javascript:;"
                                onclick="deleteCategory(<?php echo $member_bank_details->bankId(); ?>)" class="toggle">Delete</a>
                        </td>
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