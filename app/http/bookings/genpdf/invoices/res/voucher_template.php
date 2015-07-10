<?php
define('_MEXEC', 'OK');

$dateTime = new DateTime("now", new DateTimeZone('Asia/Colombo'));
$submitted_date = $dateTime->format("Y-m-d H:i:s");
$currentDate = date("F j, Y, g:i a");

$mainCity = new MainCity();
$SubCity = new SubCity();
$hotels = new Hotels();
$session = new Sessions();

$reservations = new Reservations();
$client;
$client_name = "";
$client_mobile = "";
$client_email = "";
$client_message = "";
$client_city = "";
$client_country = "";
$client_address = "";

$rooms = new HotelRoomType();

$merchantReferenceNo = $merchantReferenceNo;
$reservations->setReservationId($merchantReferenceNo);

$pay_data = $reservations->getReservationsFromId();
$pay_data = $reservations->getReservationsFromId();
$reservations->extractor($pay_data);
$reservation_link_id = $reservations->reservationFromBookingLink();
$reservations_status = $reservations->reservationPaymentStatus();

if ($reservations->reservationFromBookingLink()) {
    $client = new BookingClient();
    $client->setId($reservations->reservationClientId());
    $client->extractor($client->getClientsFromId());
    $client_name = $client->name();
    $client_mobile = $client->contactno();
    $client_email = $client->email();
    $client_message = $client->message();
    $client_city = $client->city();
    $client_country = $client->country();
    $client_address = $client->address1() . " " . $client->address2();
} else {
    $client = new Clients();
    $client->setClientId($reservations->reservationClientId());
    $client->extractor($client->getClientFromId());
    $client_name = $client->clientFirstName() . " " . $client->clientLastName();
    $client_mobile = $client->clientPhoneMobile();
    $client_email = $client->clientEmail();
    $client_message = "";
    $client_city = $client->clientCity();
    $client_country = $client->clientCountry();
    $client_address = $client->clientAddress();
}

$hotels->setHotelId($reservations->reservationHotelId());
$hotels->extractor($hotels->getHotelFromId());

$date = date("Y-m-d"); // current date
$new_date = strtotime(date("Y-m-d", strtotime($date)) . " +3 month");
$expire_date = date("Y-m-d", $new_date);

$country = new country();
$country->setCountryId($client_country);
$country->extractor($country->getCountryFromId());

$rooms->setRoomTypeId($reservations->reservationHotelRoomTypeId());
$rooms->extractor($rooms->getHotelRoomTypeFromId());

$hotel_name = $hotels->hotelName();
$hotel_url = $hotels->hotelSeoUrl();
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

$no_of_rooms = $reservations->reservationNoOfRoom();

$check_in_date = str_replace("00:00:00", "", $reservations->reservationCheckInDate());
$check_out_date = str_replace("00:00:00", "", $reservations->reservationCheckOutDate());

$startTime = strtotime($check_in_date);
$endTime = strtotime($check_out_date);
$num_of_days = round(($endTime - $startTime) / 86400);
?>

<div style="width:900px; height:auto; margin:0 auto; margin-top:100px;">

    <table width="680" border="0">
        <tr style="background-color:#02487b;">
            <td height="70" colspan="2">
                <table width="100%" border="0">
                    <tr>
                        <td width="340" rowspan="2"><img src="<?php echo HTTP_PATH; ?>/bookings/genpdf/invoices/res/roomista_logo_pdf.png"/></td>
                        <td width="300" style="font-family:Arial, Helvetica, sans-serif; font-size:27px; color:#fff; text-shadow:0px 1px 1px #01233c; text-align:right;font-weight:bold;">
                            Customer <span style="font-family:Arial, Helvetica, sans-serif; font-size:27px; color:#28a0ce; text-shadow:0px 1px 1px #01233c; text-align:left;font-weight:bold;margin-top:20px;">Invoice</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="300" height="21" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#fff; text-shadow:0px 1px 1px #01233c; text-align:right;font-weight:bold;">
                            Please print and keep this invoice for your record
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
            <td width="340" rowspan="2" style="vertical-align: top">
                <table width="340" border="0" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px; color:#a4a4a4; border-collapse: collapse;  ">
                    <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                        <td width="35%" height="30" style="color:#fff; padding-left:10px;">Booking ID</td>
                        <td width="3%" style="padding-left:2px;">:</td>
                        <td width="62%" style="padding-left:10px;"><?php echo $merchantReferenceNo; ?></td>
                    </tr>
                    <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                        <td height="30" style="color:#000000; padding-left:10px;">Customer Name</td>
                        <td style="padding-left:2px;">:</td>
                        <td style="padding-left:10px;"><?php echo $client_name; ?></td>
                    </tr>
                    <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                        <td width="35%" height="30" style="color:#fff; padding-left:10px;">Customer Mobile</td>
                        <td style="padding-left:2px;">:</td>
                        <td style="padding-left:10px;"><?php echo $client_mobile; ?></td>
                    </tr>
                    <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                        <td height="30" style="color:#000000; padding-left:10px;">Customer Email</td>
                        <td style="padding-left:2px;">:</td>
                        <td style="padding-left:10px;"><?php echo $client_email; ?></td>
                    </tr>
                    <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                        <td width="35%" height="30" style="color:#fff; padding-left:10px;">City</td>
                        <td style="padding-left:2px;">:</td>
                        <td style="padding-left:10px;"><?php echo $client_city; //$bookingclient->city();          ?></td>
                    </tr>
                    <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                        <td height="30" style="color:#000000; padding-left:10px;">Country</td>
                        <td style="padding-left:2px;">:</td>
                        <td style="padding-left:10px;"><?php echo $country->countryName(); ?></td>
                    </tr>
                    <tr style="background-color:#414141; border-bottom:solid 1px #fff;">
                        <td width="35%" height="30" style="color:#fff; padding-left:10px;">Property</td>
                        <td style="padding-left:2px;">:</td>
                        <td style="padding-left:10px;"><a href="http://roomista.com/<?php echo $hotel_url; ?>.html" target="_blank" style="text-decoration: underline; color:#808080 "><?php echo $hotel_name; ?></a></td>
                    </tr>
                    <tr style="background-color:#e3e3e3; border-bottom:solid 1px #fff;">
                        <td height="57" style="color:#000000; padding-left:10px; padding-left:10px; padding-top:10px;">Address</td>
                        <td style="padding-left:2px;">:</td>
                        <td style="padding-left:10px; padding-right:10px; padding-left:10px; padding-top:10px;"><?php echo $client_address; //$bookingclient->address1();          ?></td>
                    </tr>
                </table>
            </td>
            <td width="310" style="vertical-align: top;">
                <table width="100%" border="0" style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px; color:#666666; border-collapse: separate;  ">
                    <tr style="border-bottom:solid 2px #fff;">
                        <td width="40%" height="30" style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">Room Type</td>
                        <td width="60%" style="border:dashed 1px #cccccc; text-align:center;"><?php echo $room_type; ?></td>
                    </tr>
                    <tr style="border-bottom:solid 1px #fff;">
                        <td height="30" style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">Number of Rooms</td>
                        <td style="border:dashed 1px #cccccc; text-align:center;"><?php echo $no_of_rooms; ?></td>
                    </tr>
                    <tr style="border-bottom:solid 1px #fff;">
                        <td height="30" style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">Number of Nights</td>
                        <td style="border:dashed 1px #cccccc; text-align:center;"><?php echo $num_of_days; ?></td>
                    </tr>
                    <tr style="border-bottom:solid 1px #fff;">
                        <td height="30" style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">Arrival / Departure</td>
                        <td style="border:dashed 1px #cccccc; text-align:center;"><?php
                            echo date("d M Y", strtotime($check_in_date));
                            ;
                            ?> / <?php echo date("d M Y", strtotime($check_out_date)); ?></td>
                    </tr>
                    <tr style="border-bottom:solid 1px #fff;">
                        <td colspan="2" width="100%" height="30" style="color:#a5deff; padding-left:10px; background-color:#0b7eb4; border-bottom:solid 5px #9bd8fa;">Notes</td>
                    </tr>
                    <tr>
                        <td colspan="2" width="100%" style="border:dashed 1px #cccccc; text-align:left;"><?php echo $client_message; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="310" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#414141; border-collapse: collapse;  ">
                    <tr>
                        <td height="100" colspan="3" style="text-align: center">
                            <?php if ($payment_staus) { ?>
                                <img src="<?php echo HTTP_PATH; ?>/bookings/genpdf/invoices/res/stamp_paid.png" align="center"/>
                            <?php } else { ?>
                                <img src="<?php echo HTTP_PATH; ?>/bookings/genpdf/invoices/res/stamp_unpaid.png" align="center"/>
                            <?php }
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" height="10"></td>
        </tr>
        <tr style="vertical-align: top;">
            <td width="340" valign="top" height="100%">
                <table width="340" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#414141; border-collapse: collapse;  ">
                    <tr style="background-color:#414141; ">
                        <td height="30" colspan="3" style="color:#fff; padding-left:10px; border:solid 1px #414141; ">Reservation</td>
                    </tr>
                    <tr style="background-color:#e3e3e3; border:solid 1px #ccc; margin-bottom:1px;">
                        <td width="34%" height="30" style="padding-left:10px;">From</td>
                        <td width="31%" style="padding-left:2px;">To</td>
                        <td width="35%" style="padding-left:10px;">Rates</td>
                    </tr>
                    <tr style="background-color:#fff; border:solid 1px #ccc; margin-bottom:1px;">
                        <td width="34%" height="30" style="padding-left:10px;"><?php echo date("d M Y", strtotime($check_in_date)); ?></td>
                        <td width="31%" style="padding-left:2px;"><?php echo date("d M Y", strtotime($check_out_date)); ?></td>
                        <td width="35%" style="padding-left:10px;"><?php echo "<strong>" . $reservations->currencyType() . " " . $reservations->reservationTotalPrice() . "</strong>"; ?></td>
                    </tr>
                    <?php
                    if ($reservations->reservationOfferAvailable() == 1) {
                        $offer = unserialize(urldecode($reservations->reservationOfferData()));
                        if ($offer['OfferAvailable'] == true) {
                            ?>
                            <tr style="background-color:#e3e3e3; border:solid 1px #ccc; margin-bottom:1px;">
                                <td colspan="3" width="100%" height="25" style="padding-left:10px;">Offer</td>
                            </tr>
                            <tr style="background-color:#fff; border:solid 1px #ccc; margin-bottom:1px;">
                                <td width="34%" height="30" style="padding-left:10px;"><?php echo $offer['Title']; ?></td>
                                <?php
                                $offerAmount = 0;
                                if ($reservations->currencyType() == 'LKR') {
                                    $offerAmount = $offer['TotalLKR'] - $offer['DiscountedTotalLKR'];
                                } else {
                                    $offerAmount = $offer['Total'] - $offer['DiscountedTotal'];
                                }
                                $offerAmount = number_format((float) $offerAmount, 2, '.', '');
                                ?>
                                <td colspan="2" width="66%" style="padding-left:10px;">Offer Amount: <?php echo "<strong>" . $reservations->currencyType() . " " . $offerAmount . "</strong>"; ?></td>
                            </tr>
                            <tr style="background-color:#fff; border:solid 1px #ccc; border-top:none; margin-bottom:1px;">
                                <td colspan="3" width="100%" style="padding-left:10px;"><?php echo $offer['Description']; ?></td>
                            </tr>
                        <?php } elseif ($offer['CustomOffer'] == true) {
                            ?>
                            <tr style="background-color:#e3e3e3; border:solid 1px #ccc; margin-bottom:1px;">
                                <td colspan="3" width="100%" height="25" style="padding-left:10px;">Offer</td>
                            </tr>
                            <tr style="background-color:#fff; border:solid 1px #ccc; margin-bottom:1px;">
                                <td width="34%" height="30" style="padding-left:10px;"><?php echo $offer['Title']; ?></td>
                                <td colspan="2" width="66%" style="padding-left:10px;"><?php echo $offer['Custom'][0]['des']; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </td>
            <td width="310" valign="top">
                <table width="340" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#414141; border-collapse: collapse;  ">
                    <tr style="background-color:#414141; ">
                        <td height="30" style="color:#fff; padding-left:10px; border:solid 1px #414141; text-align:center; font-weight:bold;">Booked through and payable by :</td>
                    </tr>
                    <tr height="58" style="background-color:#e3e3e3; border:solid 1px #ccc; margin-bottom:1px;">
                        <td height="58" style="padding-left:10px;">Roomista (Pvt) Ltd, No 16/3,<br/>Cambridge Place, Colombo 7, Sri Lanka</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" height="10">&nbsp;</td>
        </tr>
        <tr>
            <td height="66" colspan="2" style="border:solid 1px #ededed;">
                <table width="660" border="0" style="font-family:Arial, Helvetica, sans-serif; color:#666; font-size:11px; margin-left:10px; margin-top:10px; margin-bottom:10px;">
                    <tr>
                        <td width="355"><strong>Notes :</strong></td>
                        <td width="10">&nbsp;</td>
                        <td width="283" rowspan="4" style="text-align:right;">
                            <strong>Call our customer service center 24/7:</strong>
                            <br/> Customer Support Head Office (Sri Lanka) :<br/> +94 (0) 777 555 832<br/> www.roomista.com
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
                        <td>
                            <strong style="font-size: 13px;">Roomista (Pvt) Ltd</strong><br/> No 16/3 Cambridge Place, Colombo 7, Sri Lanka.
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="30"></td>
        </tr>
        <tr width="680">
            <td colspan="3">
                <table>
                    <tr>
                        <td width="400" colspan="2" style="border:solid 1px #ededed; background-color:#ededed;vertical-align: top;">
                            <table>
                                <tr>
                                    <td>
                                        <table border="0" style="font-family:Arial, Helvetica, sans-serif; color:#666; font-size:11px; margin-left:10px; margin-top:10px; margin-bottom:10px;">
                                            <tr>
                                                <td colspan="2" width="100%" height="29" style="font-size:16px; color:#bd0000;">MESSAGE FOR CUSTOMER</td>
                                            </tr>
                                            <tr>
                                                <td width="5"></td>
                                                <td width="395"></td>
                                            </tr>
                                            <?php if ($payment_staus) { ?>
                                                <tr>
                                                    <td colspan="2"><strong>Thank you for your payment! Your transaction was successfully completed.</strong></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">-</td>
                                                    <td>If there are any concerns please contact us through: <br/>+94 (0) 777 555 832 (24 / 7))</td>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="2"><strong>Dear Customer, Thank you for choosing us!</strong></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">-</td>
                                                    <td>Please note your room allocation will be done once the payment is successfully completed.</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">-</td>
                                                    <td>If there are any concerns please contact us through:<br/> +94 (0) 777 555 832 (24 / 7)</td>
                                                </tr>
                                                <tr><td colspan="2" height="10"></td></tr>
                                                <tr>
                                                    <td colspan="2"><strong>Bank Details:</strong></td>
                                                </tr>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Roomista (Pvt) Ltd.</td>
                                    </tr>
                                    <tr>
                                        <td valign="top">-</td>
                                        <td>Nations Trust Bank - Cinnamon Garden Branch</td>
                                    </tr>
                        </tr>
                        <tr>
                            <td valign="top">-</td>
                            <td>A/C No: 011100014320</td>
                        </tr>
                    <?php }
                    ?>
                </table>
            </td>
        </tr>
    </table>
</td>
<td width="280" style="vertical-align: top; border:solid 1px #ededed; background-color:#ededed;">
    <table border="0" style="font-family:Arial, Helvetica, sans-serif; color:#666; font-size:11px; margin-left:10px; margin-top:10px; margin-bottom:10px;">
        <tr>
            <td style="text-align: right; line-height: 15px;">
                Scan the QR code to view your reservation online (only valid from <?php echo date("d M Y", strtotime($check_in_date) - 1); ?> to <?php echo date("d M Y", strtotime($check_out_date)); ?>).
            </td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <?php
            $url = str_replace('http://', '', HTTP_PATH) . "reservation/";
            if ($reservations->reservationFromBookingLink()) {
                $url = str_replace('http://', '', HTTP_PATH) . "bookings/reservation/";
            } else {
                $url = str_replace('http://', '', HTTP_PATH) . "reservation/";
            }
            ?>
            <td align="right" style=" text-align: right;">

<!--<img src="data:image/png;base64,<?php //echo QRCodeGen::getCode($url  .  base64_encode($merchantReferenceNo."|".date("d/m/y", strtotime($check_in_date)-1)."|".date("d/m/y", strtotime($check_out_date))) . "");         ?>" style="margin-top: -3px"/>-->
                <img src="res/reservationqrcode.php?resid=<?php echo $merchantReferenceNo; ?>" style="margin-top: -3px"/>
            </td>
        </tr>
    </table>
</td>
</tr>
</table>
</td>
</tr>
</table>

</div>


<?php
//die();
/* 	echo "<br /><br /><br /><br /><br /><br /> -end  one ";

 */
?>