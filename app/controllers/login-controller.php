<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "loginNow":
            loginNow();
            break;
        case "registerNow":
            registerNow();
            break;
        case "adminLoginNow":
            adminLoginNow();
            break;

    }

    function loginNow()
    {

        $username = $_REQUEST['login_user'];
        $password = $_REQUEST['login_password'];

        $member = new Members();
        $member->setUsername($username);

        $data = $member->getUserFromUsername();

        if (count($data) > 0) {

            $member->extractor($data);

            if ($member->password() == md5($password)) {

                $session = new Sessions();
                $session->setMemberLoginSessions($member->id(), $member->title() . " " . $member->firstName() . " " . $member->lastName(), $member->department(), $member->position());

                Common::jsonSuccess("Success");

            } else {
                Common::jsonError("Login Error");
            }
        } else {
            Common::jsonError("Login Error");
        }

    }

    function registerNow()
    {

        $members = new Members();

        $members->setValues($_REQUEST);

        if ($members->newMember()) {
            Common::jsonSuccess("Member Added Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function adminLoginNow()
    {

        $username = $_REQUEST['login_user'];
        $password = $_REQUEST['login_password'];

        $admin = new administrator();
        $admin->setUsername($username);
        $data = $admin->getAdminFromUsername();

        if (count($data) > 0) {
            $admin->extractor($data);
            if ($admin->password() == md5($password)) {
                $session = new Sessions();
                $session->setAdminLoginSessions($admin->id(), $admin->name(), $admin->email());
                Common::jsonSuccess("Success");
            } else {
                Common::jsonError("Login Error");
            }

        } else {
            Common::jsonError("Login Error");
        }

    }

    if ($_REQUEST['queryString']) {
        if ($_REQUEST['queryString'] == 'checklogin') {
            if (Sessions::memberIsLogged()) {
                echo(1);
            }
            if (Sessions::clientIsLogged()) {
                echo(1);
            }
            if (Sessions::hotelsIsLogged()) {
                echo(1);
            }
        } else if ($_REQUEST['queryString'] == 'logoutFromAll') {
            Sessions::logoutMember();
            Sessions::logoutClient();
            Sessions::logoutHotels();
            echo('redirect');
        }

    }

?>