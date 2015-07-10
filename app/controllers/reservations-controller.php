<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewReservations":
            viewReservations();
            break;
        case "addReservation":
            addReservation();
            break;
        case "updateCategory":
            updateCategory();
            break;
        case "deleteReservation":
            deleteReservation();
            break;
        case "onlinePayment":
            onlinePayment();
            break;
    }

    function viewReservations()
    {
        $reservation = new Reservations();

        $data = $reservation->getAllReservationsPaginated($_REQUEST['page']);

        $count = $reservation->getAllReservationsCount();

        viewTable($data, $count[0]['count']);

    }

    function addReservation()
    {

        $reservation = new Reservations();
        $Sessions = new Sessions();
        $reservation->setValues($_REQUEST);
        $reservation->setReservationClientId($Sessions->getClientId());
        if ($Sessions->clientIsLogged()) {
            $id = $reservation->newReservations();
            if ($id != 0) {
                Common::jsonSuccess(array("id" => $id));
            } else {
                Common::jsonError("Error");
            }
        } else {
            $Sessions->setReservationsDetails($_REQUEST);
            Common::jsonError(array("login" => 500));
        }
    }

    function onlinePayment()
    {
        $reservation = new Reservations();
        $reservation->setReservationClientId(Sessions::getClientId());
        $reservation->setReservationHotelId(Sessions::getOnlinePaymentHotelId());
        $reservation->setReservationHotelRoomTypeId(Sessions::getOnlinePaymentRoomTypeId());
        $reservation->setReservationBedType(Sessions::getOnlinePaymentBedType());
        $reservation->setReservationMealType(Sessions::getOnlinePaymentMealType());
        $reservation->setReservationNoOfRoom(Sessions::getOnlinePaymentRoomCount());
        $reservation->setReservationTotalPrice(Sessions::getOnlinePaymentRate());
        //$reservation->setCurrencyType(Sessions::currSuffix());
        $reservation->setCurrencyType(Sessions::getDisplayRatesIn());
        $reservation->setReservationCheckInDate(Sessions::getOnlinePaymentCheckin());
        $reservation->setReservationCheckOutDate(Sessions::getOnlinePaymentCheckout());
        $reservation->setReservationOfferAvailable(Sessions::getOnlinePaymentOfferAvailable());
        $reservation->setReservationOfferData(Sessions::getOnlinePaymentOfferData());

        //$reservation_id = $reservation->newReservations();

        if ($reservation->newReservations()) {
            $reservation_id = mysql_insert_id();

            Sessions::setOnlinePaymentReservationId($reservation_id);

            $client_name = "";
            $client_email = "";
            $client_contact = "";

            $client = new Clients();
            $client->setClientId(Sessions::getClientId());
            $client->extractor($client->getClientFromId());
            $client_name = $client->clientFirstName() . ' ' . $client->clientLastName();
            $client_email = $client->clientEmail();
            $client_contact = $client->clientPhoneFixed();

            $hotels_name = "";
            $hotels = new Hotels();
            $hotels->setHotelId(Sessions::getOnlinePaymentHotelId());
            $hotels->extractor($hotels->getHotelFromId());
            $hotels_name = $hotels->hotelName();

            $hotel_room_type = "";
            $room = new HotelRoomType();
            $room->setRoomTypeId(Sessions::getOnlinePaymentRoomTypeId());
            $room->extractor($room->getHotelRoomTypeFromId());
            $hotel_room_type = $room->roomTypeName();

            $bed_type = Sessions::getOnlinePaymentBedType();

            $meal_type = Sessions::getOnlinePaymentMealType();

            $room_count = Sessions::getOnlinePaymentRoomCount();

            $room_rate = Sessions::getOnlinePaymentRate() . ' ' . Sessions::currSuffix();

            $check_in = Sessions::getOnlinePaymentCheckin();

            $check_out = Sessions::getOnlinePaymentCheckout();

            $mail_tmp = '<table width="560" border="0" align="center">
                          <tr>
                            <td width="173" style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> Reservation Id </td>
                            <td width="377" style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> :' . $reservation_id . ' </td>
                          </tr>
                          <tr>
                            <td width="173" style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> Hotel </td>
                            <td width="377" style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> :' . $hotels_name . ' </td>
                          </tr>
                          <tr>
                            <td width="173" style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> Customer&rsquo; Name </td>
                            <td width="377" style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> :' . $client_name . ' </td>
                          </tr>
                          <tr>
                            <td width="173" style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> Customer&rsquo; E-mail </td>
                            <td width="377" style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> :' . $client_email . ' </td>
                          </tr>
                          <tr>
                            <td width="173" style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> Customer&rsquo; Contact </td>
                            <td width="377" style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> :' . $client_contact . ' </td>
                          </tr>
                          <tr>
                            <td style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;">  Room Type </td>
                            <td style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> :' . $hotel_room_type . ' </td>
                          </tr>
                          <tr>
                            <td style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> Bed Type</td>
                            <td style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> :' . $bed_type . ' </td>
                          </tr>
                          <tr>
                            <td height="26" valign="top" style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> Meal Type </td>
                            <td valign="top" style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px; height:auto !important; min-height:10px; height:auto;"> :' . $meal_type . ' </td>
                          </tr>

                          <tr>
                            <td height="26" valign="top" style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> No of Rooms </td>
                            <td valign="top" style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px; height:auto !important; min-height:10px; height:auto;"> :' . $room_count . ' </td>
                          </tr>

                          <tr>
                            <td height="26" valign="top" style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> Total </td>
                            <td valign="top" style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px; height:auto !important; min-height:10px; height:auto;"> :' . $room_rate . ' </td>
                          </tr>

                          <tr>
                            <td height="26" valign="top" style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> Check In </td>
                            <td valign="top" style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px; height:auto !important; min-height:10px; height:auto;"> :' . $check_in . ' </td>
                          </tr>

                          <tr>
                            <td height="26" valign="top" style="font-weight:bold; font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px;"> Check Out </td>
                            <td valign="top" style="font-size:12px; text-align: left; font-family: Arial, Helvetica, sans-serif; color:#60919f; line-height: 19px; margin: 0 0 12px; padding: 4px 3px; height:auto !important; min-height:10px; height:auto;"> :' . $check_out . ' </td>
                          </tr>
                      </table>';

            $subject = "Reservation Details Roomista.com";
            $random_hash = md5(time());
            $headers = "";
            $headers .= "\r\nContent-Type:text/html; charset=iso-8859-1\n boundary=\"PHP-alt-" . $random_hash . "\"";
            $headers = "MIME-Version: 1.0\n";
            $headers .= "Content-Type:text/html; charset=iso-8859-1\n";
            $headers .= "From:reservation@roomista.com \n";
            $headers .= "Return-Path:$client_email\n";

            //mail('info@roomista.com',$subject,$mail_tmp,$headers);
            //mail('maleewa@weblook.com',$subject,$mail_tmp,$headers);
            mail('booking@roomista.com,info@roomista.com', $subject, $mail_tmp, $headers);

            Common::jsonSuccess("payment registered");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateReservation()
    {

        $reservation = new Reservations();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $reservation->setValues($get_edited);

        if ($reservation->updateReservations()) {
            Common::jsonSuccess("Reservation Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteReservation()
    {

        $reservation = new Reservations();
        $reservation->setReservationId($_REQUEST['id']);

        if ($reservation->deleteReservations()) {
            Common::jsonSuccess("Reservation Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $reservation = new Reservations();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewReservations");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Reservations</span>
        </div>
        <div class="mws-panel-body">
            <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
                <colgroup>
                    <col class="con0"/>
                    <col class="con1"/>
                </colgroup>
                <thead>
                <tr>
                    <th class="head1">Hotel</th>
                    <th class="head0">Client</th>
                    <th class="head0">Room Rate</th>
                    <th class="head1">Total Price</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($data) > 0) { ?>

                    <?php
                    for ($i = 0; $i < count($data); $i++) {
                        $reservation->extractor($data, $i);

                        $hotels = new Hotels();
                        $hotels->setHotelId($reservation->reservationHotelId());
                        $hotels->extractor($hotels->getHotelFromId());

                        $clients = new Clients();
                        $clients->setClientId($reservation->reservationClientId());
                        $clients->extractor($clients->getClientFromId());

                        ?>
                        <tr id="row_<?php echo $reservation->reservationId(); ?>">
                            <td class="con1"><?php echo $hotels->hotelName(); ?></td>
                            <td class="con0"><?php echo $clients->clientFirstName() . ' - ' . $clients->clientFirstName(); ?></td>
                            <td class="con0"><?php echo $reservation->reservationRoomRate(); ?></td>
                            <td class="center"><?php echo $reservation->reservationTotalPrice(); ?></td>
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