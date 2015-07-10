<?php
    //define('_MEXEC','OK');
    //require_once("../../../system/load.php");
    //include('../../../config/config.php');

    $dateTime = new DateTime("now", new DateTimeZone('Asia/Colombo'));
    $submitted_date = $dateTime->format("Y-m-d H:i:s");
    $currentDate = date("F j, Y, g:i a");


    $mainCity = new MainCity();
    $SubCity = new SubCity();
    $hotels = new Hotels();
    $session = new Sessions();
    //$mail = new SystemMail();
    $reservations = new Reservations();
    $bookingclient = new BookingClient();
    $rooms = new HotelRoomType();


    $hotels->setHotelId($_SESSION['hotels_id']);
    $hotels->extractor($hotels->getHotelFromId());

    $merchantReferenceNo = $session->getMerchantReferenceNo();
    $reservations->setReservationId($merchantReferenceNo);

    $pay_data = $reservations->getReservationsFromId();
    $reservations->extractor($pay_data);
    $reservation_link_id = $reservations->reservationFromBookingLink();
    $reservations_status = $reservations->reservationPaymentStatus();


    $date = date("Y-m-d"); // current date
    $new_date = strtotime(date("Y-m-d", strtotime($date)) . " +3 month");
    $expire_date = date("Y-m-d", $new_date);

    $bookingclient->setId($reservations->reservationClientId());
    $bookingclient->extractor($bookingclient->getClientsFromId());

    $rooms->setRoomTypeId($reservations->reservationHotelRoomTypeId());
    $rooms->extractor($rooms->getHotelRoomTypeFromId());


    $client_name = $bookingclient->name();
    $hotel_name = $hotels->hotelName();
    $room_type = $rooms->roomTypeName();

    if ($reservations->reservationBedType() == "sgl") {
        $bed_type = "Single Bed";
    }
    if ($reservations->reservationBedType() == "dbl") {
        $bed_type = "Double Bed";
    }
    if ($reservations->reservationBedType() == "tpl") {
        $bed_type = "Tripple Bed";
    }

    if ($reservations->reservationBedType() == "") {
        $bed_type = "Not Selected";

    }

    if ($reservations->reservationMealType() == "bb") {
        $meal_type = "Bed & Breakfast";
    }
    if ($reservations->reservationMealType() == "hb") {
        $meal_type = "Half Board";
    }
    if ($reservations->reservationMealType() == "fb") {
        $meal_type = "Full Board";
    }
    if ($reservations->reservationMealType() == "ai") {
        $meal_type = "All Inclusive";
    }
    if ($reservations->reservationMealType() == "") {
        $meal_type = "Not Selected";
    }


    //$bed_type ="";
    //$meal_type ="";
    $no_of_rooms = $reservations->reservationNoOfRoom();
    //$check_in_date= $reservations->reservationCheckInDate();
    //$check_out_date =$reservations->reservationCheckOutDate();

    $check_in_date = str_replace("00:00:00", "", $reservations->reservationCheckInDate());
    $check_out_date = str_replace("00:00:00", "", $reservations->reservationCheckOutDate());

?>

<div style="width:900px; height:auto; margin:0 auto; margin-top:40px;">


<table width="680" border="0">
<tr style="background-color:#02487b;">
    <td height="70" colspan="2">
        <table width="100%" border="0">
            <tr>
                <td width="340" rowspan="2">&nbsp;</td>
                <td width="300"
                    style="font-family:Arial, Helvetica, sans-serif; font-size:40px; color:#fff; text-shadow:0px 1px 1px #01233c; text-align:right;font-weight:bold;">
                    Hotel <span
                        style="font-family:Arial, Helvetica, sans-serif; font-size:27px; color:#28a0ce; text-shadow:0px 1px 1px #01233c; text-align:left;font-weight:bold;margin-top:20px;">Voucher</span>
                </td>
            </tr>
            <tr>
                <td width="300" height="21"
                    style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#fff; text-shadow:0px 1px 1px #01233c; text-align:right;font-weight:bold;">
                    Please print and keep this voucher for your record
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td width="360">&nbsp;</td>
    <td width="310">&nbsp;</td>
</tr>
<tr>
    <td width="340">
        <table width="340" border="0"
               style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px; color:#a4a4a4; border-collapse: collapse;  ">
            <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                <td width="200" height="30" style="color:#fff; padding-left:10px;">Booking ID</td>
                <td width="3%" style="padding-left:2px;">:</td>
                <td width="44%" style="padding-left:10px;"><?php echo $merchantReferenceNo; ?></td>
            </tr>
            <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                <td width="53%" height="30" style="color:#333333; padding-left:10px;">Booking Reference No</td>
                <td width="3%" style="padding-left:2px;">:</td>
                <td width="44%" style="padding-left:10px;"><?php echo $merchantReferenceNo; ?></td>
            </tr>
            <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                <td width="53%" height="30" style="color:#fff; padding-left:10px;">Customer Name</td>
                <td width="3%" style="padding-left:2px;">:</td>
                <td width="44%" style="padding-left:10px;"><?php echo $client_name; ?></td>
            </tr>


            <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                <td width="53%" height="30" style="color:#333333; padding-left:10px;">City</td>
                <td width="3%" style="padding-left:2px;">:</td>
                <td width="44%" style="padding-left:10px;"><?php echo $bookingclient->city(); ?></td>
            </tr>
            <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                <td width="53%" height="30" style="color:#fff; padding-left:10px;">Country</td>
                <td width="3%" style="padding-left:2px;">:</td>
                <td width="44%" style="padding-left:10px;"><?php echo $bookingclient->country(); ?></td>
            </tr>
            <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                <td width="53%" height="30" style="color:#333333; padding-left:10px;">Hotel</td>
                <td width="3%" style="padding-left:2px;">:</td>
                <td width="44%" style="padding-left:10px;"><?php echo $hotel_name; ?></td>
            </tr>
            <tr valign="top" style="background-color:#414141; border-bottom:solid 1px #fff;">
                <td width="53%" height="57" style="color:#fff; padding-left:10px; padding-left:10px; padding-top:10px;">
                    Address
                </td>
                <td width="3%" style="padding-left:2px;">:</td>
                <td style="padding-left:10px; padding-right:10px; padding-left:10px; padding-top:10px;"><?php echo $bookingclient->address1(); ?></td>
            </tr>

        </table>
    </td>
    <td width="310">
        <table width="300" border="0"
               style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px; color:#666666; border-collapse: separate;  ">
            <tr style="border-bottom:solid 2px #fff;">
                <td width="51%" height="30"
                    style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">
                    Room Type
                </td>
                <td width="49%" style="border:dashed 1px #cccccc; text-align:center;"><?php echo $room_type; ?></td>
            </tr>
            <tr style="border-bottom:solid 1px #fff;">
                <td width="51%" height="30"
                    style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">
                    Number of Rooms
                </td>
                <td width="49%" style="border:dashed 1px #cccccc; text-align:center;"><?php echo $no_of_rooms; ?></td>
            </tr>
            <tr style="border-bottom:solid 1px #fff;">
                <td width="51%" height="30"
                    style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">
                    Number of Days
                </td>
                <td width="49%" style="border:dashed 1px #cccccc; text-align:center;"><?php echo 2; ?></td>
            </tr>
            <tr style="border-bottom:solid 1px #fff;">
                <td width="51%" height="30"
                    style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">
                    Notes
                </td>
                <td width="49%"
                    style="border:dashed 1px #cccccc; text-align:center;"><?php echo $merchantReferenceNo; ?></td>
            </tr>
            <tr style="border-bottom:solid 1px #fff;">
                <td width="51%" height="30"
                    style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">
                    Arrival / Departure
                </td>
                <td width="49%" style="border:dashed 1px #cccccc; text-align:center;"><?php echo $check_in_date; ?>
                    - <?php echo $check_out_date; ?></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td width="340">&nbsp;</td>
    <td width="310">&nbsp;</td>
</tr>
<tr>
    <td width="340">
        <table width="340" border="0"
               style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#414141; border-collapse: collapse;  ">
            <tr style="background-color:#414141; ">
                <td height="30" colspan="3" style="color:#fff; padding-left:10px; border:solid 1px #414141; ">
                    http://www.roomista.com/
                </td>
            </tr>
            <tr style="background-color:#e3e3e3; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="34%" height="30" style="padding-left:10px;">From</td>
                <td width="31%" style="padding-left:2px;">To</td>
                <td width="35%" style="padding-left:10px;">Rates</td>
            </tr>
            <tr style="background-color:#fff; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="34%" height="30"
                    style="padding-left:10px;"><?php echo date("Y/m/d", strtotime($check_in_date)); ?></td>
                <td width="31%" style="padding-left:2px;"><?php echo date("Y/m/d", strtotime($check_out_date)); ?></td>
                <td width="35%" style="padding-left:10px;"><?php echo($reservations->reservationTotalPrice()); ?></td>
            </tr>

        </table>
    </td>
    <td width="310">
        <table width="300" border="0"
               style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#414141; border-collapse: collapse;  ">
            <tr style="background-color:#414141; ">
                <td height="30" colspan="3" style="color:#fff; padding-left:10px;border:solid 1px #414141;"></td>
            </tr>
            <tr style="background-color:#e3e3e3; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="34%" height="30" style="padding-left:8px;">From</td>
                <td width="31%" style="padding-left:8px;">To</td>
                <td width="35%" style="padding-left:8px;">Extra Bed</td>
            </tr>
            <tr style="background-color:#fff; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="34%" height="30" style="padding-left:8px;"></td>
                <td width="31%" style="padding-left:8px;"></td>
                <td width="35%" style="padding-left:8px;"></td>
            </tr>
            <tr style="background-color:#fff; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="34%" height="30" style="padding-left:8px;"></td>
                <td width="31%" style="padding-left:8px;"></td>
                <td width="35%" style="padding-left:8px;"></td>
            </tr>

        </table>
    </td>
</tr>
<tr>
    <td width="360" height="21">&nbsp;</td>
    <td width="310">&nbsp;</td>
</tr>
<tr>
    <td colspan="2">

        <table width="100%" border="0">
            <tr>
                <td width="450" height="116">
                    <table width="450" border="0"
                           style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#414141; border-collapse: separate;">
                        <tr style="background-color:#414141; color:#fff; font-weight:bold;">
                            <td width="51%" height="52" style="text-align:center; border:solid 8px #ccc;">Amount Payable
                                : USD <?php echo $reservations->reservationTotalPrice(); ?></td>
                            <td width="49%" colspan="2" style="text-align:center; border:solid 8px #ccc;">Booked and
                                payable by :
                            </td>
                        </tr>
                        <tr style="background-color:#ededed; ">
                            <td width="51%" height="52"
                                style="text-align:center; border:solid 1px #ccc;background-color:#ededed;">
                                This booking should be charged to the following credit car on departure date.
                            </td>
                            <td colspan="2" style="text-align:center; border:solid 1px #ccc;background-color:#ededed;">
                                Roomista Company Pvt Ltd, No 16/3 Cambridge Place,
                                Colombo 7
                            </td>
                        </tr>


                    </table>
                </td>
                <td width="32%">
                    <table width="200" border="0">
                        <tr>
                            <td height="47">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="62">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


    </td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>


<tr>
    <td height="66" colspan="2" style="border:solid 1px #ededed;">
        <table width="660" border="0"
               style="font-family:Arial, Helvetica, sans-serif; color:#666; font-size:11px; margin-left:10px; margin-top:10px; margin-bottom:10px;">
            <tr>
                <td width="355"><strong>Notes to customer invoice :</strong></td>
                <td width="10">&nbsp;</td>
                <td width="283" rowspan="4" style="text-align:right;">
                    <strong>Call our customer service center 24/7:</strong> <br/>
                    Customer Support Head Offer (Sri Lanka) : +00 0 000 0000 <br/>
                    http://www.roomista.com/
                </td>
            </tr>
            <tr>
                <td>All special requests are subject to availability upon arrival.</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Mailing Address :</strong></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Roomista Company Pvt Ltd, No 16/3 Cambridge Place,Colombo 7, Sri Lanka.</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td height="87" colspan="2" style="border:solid 1px #ededed; background-color:#ededed;">
        <table width="660" border="0"
               style="font-family:Arial, Helvetica, sans-serif; color:#666; font-size:11px; margin-left:10px; margin-top:10px; margin-bottom:10px;">
            <tr>
                <td width="7" style="font-size:16px; color:#bd0000;">&nbsp;</td>
                <td width="700" height="29" style="font-size:16px; color:#bd0000;">ATTENTION HOTEL STAFF</td>
                <td width="13">&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><strong>You need ensure the following at check-in:</strong></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>-</td>
                <td>Guest holds hotel voucher with the correct reservation deals</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>-</td>
                <td>Guest holds hotel voucher with the correct reservation deals</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>-</td>
                <td>Guest holds hotel voucher with the correct reservation deals</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">If you have any questions regarding the documents provided by the guest, please contact
                    +00 000000 (available 24/7)
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>

</div>