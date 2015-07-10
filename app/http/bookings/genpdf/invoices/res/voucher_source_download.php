<?php
    if(session_id() == '') { //For versions of PHP < 5.4.0
        session_start();
    }

    //For versions of PHP >= 5.4.0
    /*if (session_status() == PHP_SESSION_NONE) {
    	session_start();
    }*/
    include('../../../config/config.php');
    require_once('../../../_classes/reservation_class.php');
    require_once('../../../_classes/hotel_class.php');

    $classReservation = new RESERVATION;
    $classHotel = new HOTEL;

    $dateTime = new DateTime("now", new DateTimeZone('Asia/Colombo'));
    $submitted_date = $dateTime->format("Y-m-d H:i:s");
    $currentDate = date("F j, Y, g:i a");


    $reservation_id = mysql_real_escape_string($_SESSION['reservation_id']);

    $getReservationDetailByIdCall = $classReservation->getReservationDetailById($reservation_id);
    $rowReservation = mysql_fetch_array($getReservationDetailByIdCall);

    $rowReceAddedHotImgMainCount = mysql_num_rows($classHotel->getHotelImagesByHotelId($rowReservation['hotel_id'], '', ''));
    //hotel_id,limit,position
    $getHotelImagesByHotelIdCall = $classHotel->getHotelImagesByHotelId($rowReservation['hotel_id'], '', rand(1, $rowReceAddedHotImgMainCount));
    $rowReceAddedHotImgMain = mysql_fetch_array($getHotelImagesByHotelIdCall);

    $date = date("Y-m-d"); // current date
    $new_date = strtotime(date("Y-m-d", strtotime($date)) . " +3 month");
    $expire_date = date("Y-m-d", $new_date);

?>

<div style="width:900px; height:auto; margin:0 auto; margin-top:40px;">


<table width="654" border="0">
<tr style="background-color:#02487b;">
    <td height="70" colspan="2">
        <table width="671" border="0">
            <tr>
                <td width="187" rowspan="2">&nbsp;</td>
                <td width="344" align="right"
                    style="font-family:Arial, Helvetica, sans-serif; font-size:40px; color:#fff; text-shadow:0px 1px 1px #01233c;font-weight:bold;">
                    Hotel
                </td>
                <td width="126" align="right"
                    style="font-family:Arial, Helvetica, sans-serif; font-size:27px; color:#28a0ce; text-shadow:0px 1px 1px #01233c; font-weight:bold;padding-top:10px;">
                    Voucher
                </td>
            </tr>
            <tr>
                <td height="21" colspan="2"
                    style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#fff; text-shadow:0px 1px 1px #01233c; text-align:right;font-weight:bold;">
                    Please print and keep this voucher for your record
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td width="354">&nbsp;</td>
    <td width="330">&nbsp;</td>
</tr>
<tr>
    <td width="354">
        <table width="300" border="0"
               style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px; color:#a4a4a4; border-collapse: collapse;  ">
            <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                <td width="155" height="30" style="color:#fff; padding-left:10px;">Booking ID</td>
                <td width="10" style="padding-left:2px;">:</td>
                <td width="88" style="padding-left:10px;"><?= $rowReservation['reservation_id'] ?></td>
            </tr>
            <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                <td width="155" height="30" style="color:#333333; padding-left:10px;">Booking Reference No</td>
                <td width="10" style="padding-left:2px;">:</td>
                <td width="88" style="padding-left:10px;"><?= $rowReservation['reservation_id'] ?></td>
            </tr>
            <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                <td width="155" height="30" style="color:#fff; padding-left:10px;">Customer First Name</td>
                <td width="10" style="padding-left:2px;">:</td>
                <td width="88" style="padding-left:10px;"><?= $rowReservation['client_first_name'] ?></td>
            </tr>
            <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                <td width="155" height="30" style="color:#333333; padding-left:10px;">Customer Last Name</td>
                <td width="10" style="padding-left:2px;">:</td>
                <td width="88" style="padding-left:10px;"><?= $rowReservation['client_last_name'] ?></td>
            </tr>
            <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                <td width="155" height="30" style="color:#fff; padding-left:10px;">Country of Passport</td>
                <td width="10" style="padding-left:2px;">:</td>
                <td width="88" style="padding-left:10px;"><?= $rowReservation['client_passport'] ?></td>
            </tr>
            <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                <td width="155" height="30" style="color:#333333; padding-left:10px;">City</td>
                <td width="10" style="padding-left:2px;">:</td>
                <td width="88" style="padding-left:10px;"><?= $rowReservation['client_city'] ?></td>
            </tr>
            <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                <td width="155" height="30" style="color:#fff; padding-left:10px;">Country</td>
                <td width="10" style="padding-left:2px;">:</td>
                <td width="88" style="padding-left:10px;"><?= $rowReservation['country_name'] ?></td>
            </tr>
            <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                <td width="155" height="30" style="color:#333333; padding-left:10px;">Hotel</td>
                <td width="10" style="padding-left:2px;">:</td>
                <td width="88" style="padding-left:10px;"><?= $rowReservation['hotel_name'] ?></td>
            </tr>
            <tr valign="top" style="background-color:#414141; border-bottom:solid 1px #fff;">
                <td width="155" height="57" style="color:#fff; padding-left:10px; padding-left:10px; padding-top:10px;">
                    Address
                </td>
                <td width="10" style="padding-left:2px;">:</td>
                <td width="88"
                    style="padding-left:10px; padding-right:10px; padding-left:10px; padding-top:10px;"><?= $rowReservation['client_address'] ?></td>
            </tr>

        </table>
    </td>
    <td width="330">
        <table width="290" border="0"
               style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px; color:#666666; border-collapse: separate;  ">
            <tr style="border-bottom:solid 2px #fff;">
                <td width="51%" height="30"
                    style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">
                    Room Type
                </td>
                <td width="49%"
                    style="border:dashed 1px #cccccc; text-align:center;"><?= $rowReservation['room_type_name'] ?></td>
            </tr>
            <tr style="border-bottom:solid 1px #fff;">
                <td width="51%" height="30"
                    style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">
                    Number of Rooms
                </td>
                <td width="49%"
                    style="border:dashed 1px #cccccc; text-align:center;"><?= $rowReservation['no_of_room'] ?></td>
            </tr>
            <tr style="border-bottom:solid 1px #fff;">
                <td width="51%" height="30"
                    style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">
                    Number of Days
                </td>
                <td width="49%"
                    style="border:dashed 1px #cccccc; text-align:center;"><?= $rowReservation['no_of_dates'] ?></td>
            </tr>
            <tr style="border-bottom:solid 1px #fff;">
                <td width="51%" height="30"
                    style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">
                    Notes
                </td>
                <td width="49%"
                    style="border:dashed 1px #cccccc; text-align:center;"><?= $rowReservation['reservation_id'] ?></td>
            </tr>
            <tr style="border-bottom:solid 1px #fff;">
                <td width="51%" height="30"
                    style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">
                    Arrival / Departure
                </td>
                <td width="49%"
                    style="border:dashed 1px #cccccc; text-align:center;"><?= $rowReservation['check_in_date'] ?>
                    - <?= $rowReservation['check_out_date'] ?></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td width="354">&nbsp;</td>
    <td width="330">&nbsp;</td>
</tr>
<tr>
    <td width="354">
        <table width="300" border="0"
               style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#414141; border-collapse: collapse;  ">
            <tr style="background-color:#414141; ">
                <td width="300" height="30" colspan="3"
                    style="color:#fff; padding-left:10px; border:solid 1px #414141; ">http://www.roomista.com/
                </td>
            </tr>
            <tr style="background-color:#e3e3e3; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="100" height="30" style="padding-left:10px;">From</td>
                <td width="100" style="padding-left:2px;">To</td>
                <td width="90" style="padding-left:10px;">Rates</td>
            </tr>
            <tr style="background-color:#fff; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="100" height="30" style="padding-left:10px;"><?= $rowReservation['check_in_date'] ?></td>
                <td width="100" style="padding-left:2px;"><?= $rowReservation['check_out_date'] ?></td>
                <td width="90" style="padding-left:10px;">USD <?= $rowReservation['total'] ?></td>
            </tr>

        </table>
    </td>
    <td width="330">
        <table width="300" border="0"
               style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#414141; border-collapse: collapse;  ">
            <tr style="background-color:#414141; ">
                <td width="300" height="30" colspan="3"
                    style="color:#fff; padding-left:10px;border:solid 1px #414141;"></td>
            </tr>
            <tr style="background-color:#e3e3e3; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="100" height="30" style="padding-left:8px;">From</td>
                <td width="100" style="padding-left:8px;">To</td>
                <td width="90" style="padding-left:8px;">Extra Bed</td>
            </tr>
            <tr style="background-color:#fff; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="100" height="30" style="padding-left:8px;"></td>
                <td width="100" style="padding-left:8px;"></td>
                <td width="90" style="padding-left:8px;"></td>
            </tr>
            <tr style="background-color:#fff; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="100" height="30" style="padding-left:8px;"></td>
                <td width="100" style="padding-left:8px;"></td>
                <td width="90" style="padding-left:8px;"></td>
            </tr>

        </table>
    </td>
</tr>
<tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td width="354" height="21">
        <table width="300" border="0"
               style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#414141; border-collapse: collapse;  ">
            <tr style="background-color:#414141; ">
                <td width="300" height="38" style="color:#fff; padding-left:10px; border:solid 1px #414141; ">Amount
                    Payable : USD <?= $rowReservation['total'] ?></td>
            </tr>
            <tr style="background-color:#e3e3e3; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="300" height="30" style="padding-left:10px;">This booking should be charged to the following
                    credit car on departure date.
                </td>
            </tr>


        </table>
    </td>
    <td width="330">

        <table width="300" border="0"
               style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#414141; border-collapse: collapse;  ">
            <tr style="background-color:#414141; ">
                <td width="300" height="38" style="color:#fff; padding-left:10px; border:solid 1px #414141; ">Booked and
                    payable by :
                </td>
            </tr>
            <tr style="background-color:#e3e3e3; border:solid 1px #ccc; margin-bottom:1px;">
                <td width="300" height="30" style="padding-left:10px;">This booking should be charged to the following
                    credit car on departure date.
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
                <td width="324"><strong>Notes to customer invoice :</strong></td>
                <td width="10">&nbsp;</td>
                <td width="312" rowspan="4" style="text-align:right;">
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