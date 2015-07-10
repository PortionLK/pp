<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    $front_action = $_REQUEST['front_action'];

///print_r($_REQUEST);

    switch ($action) {

        case "viewClients":
            viewClients();
            break;
        case "addClients":
            addClients();
            break;
        case "updateClients":
            updateClients();
            break;
        case "deleteClients":
            deleteClients();
            break;
    }

    switch ($front_action) {

        case "addFrontClients":
            addFrontClients();
            break;

    }

    function viewClients()
    {
        $Clients = new Clients();
        $data = $Clients->getAllClientsPaginated($_REQUEST['page']);

        $count = $Clients->getAllClientsCount();

        viewTable($data, $count[0]['count']);

    }

    function addClients()
    {

        $Clients = new BookingClient();

        $Clients->setValues($_REQUEST);

        if ($Clients->newClients()) {
            Common::jsonSuccess("Clients Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function addFrontClients()
    {

        $Clients = new BookingClient();
        $session = new Sessions();
        $reservation = new Reservations();

        $Clients->setValues($_REQUEST);

        $from_date = date('Y-m-d', strtotime($_SESSION['check_in_date']));
        $to_date = date('Y-m-d', strtotime($_SESSION['check_out_date']));

        $reservation->setReservationHotelId($_SESSION['hotels_id']);
        $reservation->setReservationHotelRoomTypeId($_REQUEST['roomTypeId']);
        $reservation->setReservationBedType($_REQUEST['room_bed_type']);
        $reservation->setReservationMealType($_REQUEST['room_meal_type']);
        $reservation->setReservationNoOfRoom($_REQUEST['room_count']);
        $reservation->setReservationTotalPrice($_REQUEST['amount']);
        $reservation->setReservationFromBookingLink(1);
        $reservation->setReservationCheckInDate($from_date);
        $reservation->setReservationCheckOutDate($to_date);
        $reservation->setCurrencyType(Sessions::getDisplayRatesIn());
        $reservation->setReservationOfferAvailable(Sessions::getOnlinePaymentOfferAvailable());
        $reservation->setReservationOfferData(Sessions::getOnlinePaymentOfferData());

        $session->setRoomType($_REQUEST['roomTypeId']);
        $session->setRoomBedType($_REQUEST['room_bed_type']);
        $session->setRoomMealType($_REQUEST['room_meal_type']);
        $session->setAmount($_REQUEST['amount']);
        $session->setRoomNum($_REQUEST['room_count']);

        if ($Clients->addClients()) {
            $id = mysql_insert_id();
            $reservation->setReservationClientId($id);

            if($reservation->newReservations()) {
                $reservation_id = mysql_insert_id();
                $session->setMerchantReferenceNo($reservation_id);
                Common::jsonSuccess($reservation_id);
            }else{
                Common::jsonError("Error");
            }
            //echo $reservation_id;
        } else {
            echo 2;
        }

    }

    function updateClients()
    {

        $Clients = new BookingClient();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $Clients->setValues($get_edited);

        if ($Clients->updateClients()) {
            Common::jsonSuccess("Clients Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteClients()
    {

        $Clients = new BookingClient();
        $Clients->setClientsId($_REQUEST['id']);

        if ($Clients->deleteClients()) {
            Common::jsonSuccess("Clients Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $Clients = new Clients();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewClients");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Clients</span>
        </div>
        <div class="mws-panel-body">
            <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
                <thead>
                <tr>
                    <th>Clients Name</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($data) > 0) { ?>

                    <?php
                    for ($i = 0; $i < count($data); $i++) {
                        $Clients->extractor($data, $i);
                        ?>
                        <tr id="row_<?php echo $Clients->ClientsId(); ?>">
                            <td><?php echo $Clients->ClientsName(); ?></td>
                            <td class="center">
                                <a onclick="loadGUIContent('Clients','edit','<?php echo $Clients->ClientsId(); ?>')">Edit</a>
                                <a onclick="deleteClients(<?php echo $Clients->ClientsId(); ?>)"
                                   class="toggle">Delete</a>
                            </td>
                            <td></td>
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