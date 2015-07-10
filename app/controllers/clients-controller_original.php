<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewClients":
            viewClients();
            break;
        case "addClient":
            addClient();
            break;
        case "updateClient":
            updateClient();
            break;
        case "deleteClient":
            deleteClient();
        case "ExisUserName":
            ExisUserName();
            break;
        case "ExisEmail":
            ExisEmail();
            break;
        case "ExisEmailEdit":
            ExisEmailEdit();
            break;
        case "loginClient":
            loginClient();
            break;
        case "logout":
            logout();
            break;
        case "changeLogin":
            changeLogin();
            break;

    }

    function viewClients()
    {
        $clients = new Clients();
        $data = $clients->getAllClientsPaginated($_REQUEST['page']);

        $count = $clients->getAllClientsCount();

        viewTable($data, $count[0]['count']);

    }

    function addClient()
    {

        $clients = new Clients();
        $sessions = new Sessions();
        //$mailClass = new mailClass();

        $clients->setValues($_REQUEST);
        if (strtolower($_REQUEST['captcha_code']) == strtolower($_SESSION['random_number'])) {
            $clients_id = $clients->newClients();

            if ($clients_id != 0) {
                $sessions->setClientLoginSessions($clients_id, $clients->clientTitle(), $clients->clientFirstName(), $clients->clientLastName());

                //$mailClass->clientRegistration($clients->clientTitle(),$clients->clientFirstName(),$clients->clientLastName(),$clients->clientUsername(),$clients->clientEmail(),$_REQUEST['client_password']);
                Common::jsonSuccess("");
            } else {
                Common::jsonError("Error");
            }
        } else {
            // if em
            Common::jsonError(array("captcha" => 500));
        }

    }

    function updateClient()
    {

        $clients = new Clients();
        $sessions = new Sessions();
        $clients->setValues($_REQUEST);
        if (strtolower($_REQUEST['captcha_code']) == strtolower($_SESSION['random_number'])) {
            if ($clients->updateClient()) {

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

        $clients = new Clients();
        $clients->setValues($_REQUEST);
        if ($clients->changeLogin()) {
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
        header("Location: " . HTTP_PATH . "clients/?q=l");
    }

    function deleteClient()
    {

        $clients = new Clients();
        $clients->setClientId($_REQUEST['id']);

        if ($clients->deleteClient()) {
            Common::jsonSuccess("Clients Deleted Succesfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function ExisUserName()
    {

        $clients = new Clients();
        $clients->setClientUsername($_REQUEST['client_username']);
        $details = $clients->isUserNameExsists();
        echo $details;

    }

    function ExisEmail()
    {
        $clients = new Clients();
        $clients->setClientEmail($_REQUEST['client_email']);
        $details = $clients->isEmailExsists();
        echo $details;
    }

    function ExisEmailEdit()
    {
        $clients = new Clients();
        $clients->setClientEmail($_REQUEST['client_email']);
        $clients->setClientId($_REQUEST['client_id']);
        $details = $clients->isUserNameExsistsEdit();
        echo $details;
    }

    function loginClient()
    {
        $username = $_REQUEST['client_username_log'];
        $password = $_REQUEST['client_password_log'];

        $client = new Clients();
        $session = new Sessions();
        $client->setClientUsername($username);
        $data = $client->getClientFromUsername();

        if (count($data) > 0) {

            $client->extractor($data);
            if (strcmp($client->clientPassword(), md5($password)) == 0) {

                $session->setClientLoginSessions($client->clientId(), $client->clientTitle(), $client->clientFirstName(), $client->clientLastName());
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

        $clients = new Clients();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewClients");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Client</span>
        </div>
        <div class="mws-panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
            <thead>
            <tr>
                <th>Client Name</th>
                <th>Client Address</th>
                <th>Client Email</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data) > 0) { ?>

                <?php
                for ($i = 0; $i < count($data); $i++) {
                    $clients->extractor($data, $i);
                    ?>
                    <tr id="row_<?php echo $clients->clientId(); ?>">
                        <td><?php echo $clients->clientFirstName() . ' ' . $clients->clientLastName(); ?></td>
                        <td><?php echo $clients->clientAddress(); ?></td>
                        <td><?php echo $clients->clientEmail(); ?></td>
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