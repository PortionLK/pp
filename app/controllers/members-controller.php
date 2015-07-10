<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewMembers":
            viewMembers();
            break;
        case "addMember":
            addMember();
            break;
        case "updateMember":
            updateMember();
            break;
        case "deleteMember":
            deleteMember();
            break;
        case "ExisUserName":
            ExisUserName();
            break;
        case "ExisEmail":
            ExisEmail();
            break;
        case "ExisEmailEdit":
            ExisEmailEdit();
            break;
        case "memberLogin":
            memberLogin();
            break;
        case "logout":
            logout();
            break;
        case "changeLogin":
            changeLogin();
            break;
    }

    function viewMembers()
    {
        $members = new Members();

        $data = $members->getAllMemberPaginated($_REQUEST['page']);

        $count = $members->getAllMemberCount();

        viewTable($data, $count[0]['count']);

    }

    function addMember()
    {

        $members = new Members();
        $sessions = new Sessions();
        $mailClass = new mailClass();
        $members->setValues($_REQUEST);

        if (strtolower($_REQUEST['captcha_code']) == strtolower($_SESSION['random_number'])) {
            $members_id = $members->newMember();
            if ($members_id != 0) {
                $mailClass->MemberRegistration($members->memberTitle(),$members->memberFirstName(),$members->memberLastName(),$members->memberUsername(),$members->memberEmail(),$_REQUEST['member_password']);
                $sessions->setMemberLoginSessions($members_id, $members->memberTitle(), $members->memberFirstName(), $members->memberLastName());
                Common::jsonSuccess(array("success" => 200));
            } else {
                Common::jsonError("Error");
            }
        } else {
            Common::jsonError(array("captcha" => 500));
        }

    }

    function updateMember()
    {
        $members = new Members();
        $members->setValues($_REQUEST);

        if (trim(strtolower($_REQUEST['captcha_code'])) == trim(strtolower($_SESSION['random_number']))) {
            if ($members->updateMember()) {
                Common::jsonSuccess("");
            } else {
                Common::jsonError("Error");
            }
        } else {
            // if em
            Common::jsonError(array("captcha" => 500));
        }

    }

    function changeLogin()
    {
        $members = new Members();
        $oldMember = new Members();
        $mailClass = new mailClass();
        $members->setValues($_REQUEST);
        $oldMember->setMemberUsername($_REQUEST['members_username_log']);
        $oldMember->extractor($oldMember->getMemberByUsername());

        if ($members->changeLogin()) {
            $mailClass->MemberChangeLogin($oldMember->memberTitle(),$oldMember->memberFirstName(),$oldMember->memberLastName(),$_REQUEST['members_username_log'],$oldMember->memberEmail(),$_REQUEST['member_password']);
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }

    }

    function logout()
    {
        $sessions = new Sessions();
        $sessions->logoutMember();
        $sessions->logoutClient();
        $sessions->logoutHotels();
        header("Location: " . HTTP_PATH . "register/?q=l");
    }

    function deleteMember()
    {

        $members = new Members();
        $members->setMemberId($_REQUEST['id']);

        if ($members->deleteMember()) {
            Common::jsonSuccess("Members Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function ExisUserName()
    {

        $members = new Members();
        $members->setMemberUsername($_REQUEST['member_username']);
        $details = $members->isUserNameExsists();
        echo $details;

    }

    function ExisEmail()
    {
        $members = new Members();
        $members->setMemberId($_REQUEST['member_id']);
        $members->setMemberEmail($_REQUEST['member_email']);
        $details = $members->isEmailExsists();
        echo $details;
    }

    function ExisEmailEdit()
    {
        $members = new Members();
        $members->setMemberEmail($_REQUEST['member_email']);
        $members->setMemberId($_REQUEST['member_id']);
        $details = $members->isEmailExsists();
        echo $details;
    }

    function memberLogin()
    {

        $member = new Members();
        $member->setMemberUsername($_REQUEST['member_username_login']);
        $data = $member->getMemberByUsername();

        if (count($data) > 0) {

            $member->extractor($data);
            if (strcmp($member->memberPassword(), md5($_REQUEST['member_password_login'])) == 0) {
                $session = new Sessions();
                $session->setMemberLoginSessions($member->memberId(), $member->memberTitle(), $member->memberFirstName(), $member->memberLastName());
                Common::jsonSuccess("Success");
            } else {
                Common::jsonError("Login Error");
            }

        } else {
            Common::jsonError("Login Error");
        }
    }

    function viewTable($data, $count)
    {

        $memberss = new Members();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewMembers");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Member</span>
        </div>
        <div class="mws-panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Username</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data) > 0) { ?>

                <?php
                for ($i = 0; $i < count($data); $i++) {
                    $memberss->extractor($data, $i);
                    ?>
                    <tr id="row_<?php echo $memberss->memberId(); ?>">
                        <td><?php echo $memberss->memberFirstName() . ' ' . $memberss->memberLastName(); ?></td>
                        <td><?php echo $memberss->memberEmail(); ?></td>
                        <td><?php echo $memberss->memberUsername(); ?></td>
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