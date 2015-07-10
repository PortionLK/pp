<?php
define('_MEXEC', 'OK');
require_once("../../../system/load.php");
//error_reporting(E_ALL);
//Mail Controllers
require_once('../../../smtpmailclass/class.phpmailer.php');
require_once('../../../smtpmailclass/class.smtp.php'); // optional, gets called from within class.phpmailer.php if not

$hotels = new Hotels();
$session = new Sessions();

$reservations = new Reservations();
$bookingclient = new BookingClient();
$bookingclient = new BookingClient();
$rooms = new HotelRoomType();
$client;

$merchantReferenceNo = $_REQUEST['resid']; //$session->getMerchantReferenceNo();

$reservations->setReservationId($merchantReferenceNo);
$pay_data = $reservations->getReservationsFromId();
$reservations->extractor($pay_data);
$reservation_link_id = $reservations->reservationFromBookingLink();
$reservations_status = $reservations->reservationPaymentStatus();

if ($reservations->reservationFromBookingLink()) {
    $client = new BookingClient();
    $client->setId($reservations->reservationClientId());
    $client->extractor($client->getClientsFromId());
    $client_name = $client->name();
    $client_email = $client->email();
} else {
    $client = new Clients();
    $client->setClientId($reservations->reservationClientId());
    $client->extractor($client->getClientFromId());
    $client_name = $client->clientFirstName() . " " . $client->clientLastName();
    $client_email = $client->clientEmail();
}

$hotels->setHotelId($reservations->reservationHotelId());
$hotels->extractor($hotels->getHotelFromId());

$date = date("Y-m-d"); // current date
$new_date = strtotime(date("Y-m-d", strtotime($date)) . " +3 month");
$expire_date = date("Y-m-d", $new_date);

$rooms->setRoomTypeId($reservations->reservationHotelRoomTypeId());
$rooms->extractor($rooms->getHotelRoomTypeFromId());

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

$no_of_rooms = $reservations->reservationNoOfRoom();

$check_in_date = str_replace("00:00:00", "", $reservations->reservationCheckInDate());
$check_out_date = str_replace("00:00:00", "", $reservations->reservationCheckOutDate());

$currency_type = $reservations->currencyType();
$payment_staus = $reservations->reservationPaymentStatus();
$pdf_message = "";

if ($payment_staus) {
    $pdf_message = "Your Reservation is Successful. Thank you for choosing Roomista.com as your booking engine";
} else {
    $pdf_message = "Sorry Reservation is Unsuccessful. Thank you for choosing Roomista.com as your booking engine";
}

ob_start();
include(dirname(__FILE__) . "/res/voucher_template.php");

$content = ob_get_clean();
require_once(dirname(__FILE__) . '/../mPDF/mpdf.php');

try {
    $pdf = new mpdf('', // mode - default ''
            strtoupper('A4'), // format - A4, for example, default ''
            0, // font size - default 0
            'Arial, Helvetica, sans-serif', // default font family
            20, // margin_left
            15, // margin right
            20, // margin top
            5, // margin bottom
            0, // margin header
            0, // margin footer
            'L'         // L - landscape, P - portrait
    );

    $pdf->AddPage($orientation);
    //  Document info
    $pdf->SetTitle("Customer Invoice");
    $pdf->SetAuthor("roomista.com");
    $pdf->SetSubject("Customer Invoice");
    $pdf->SetKeywords("Customer Invoice");
    $pdf->SetCreator("roomista.com");

    $pdf->WriteHTML(utf8_encode($content));
    $filename = "Reservation_client_invoice.pdf";

    if ($_REQUEST['force'] == 'email') {

        $content = $pdf->Output('invoive.pdf', 'S');
        $content = chunk_split(base64_encode($content));
        $mail = new PHPMailer();

        $body = "<table width='745' style='font-family: Arial, Helvetica, sans-serif'>
                    <tr>
                        <td width='745' style='text-align: center; font-size: 20pt;'>Congratulations</td>
                    </tr>
                    <tr>
                        <td height='25' ></td>
                    </tr>
                    <tr>
                        <td width='745' style='text-align: center; font-size: 14pt; '>Your reservation was successfully completed</td>
                    </tr>
                    <tr>
                        <td height='10' ></td>
                    </tr>
                    <tr>
                        <td width='745' style='text-align: left; font: 700 '>We have attached the customer invoice for your reference. Do have a copy of the same when checking in at the hotel.</td>
                    </tr>
                    <tr>
                        <td width='745' style='text-align: left; font: 700 '>Wishing you a pleasant stay.</td>
                    </tr>
                    <tr>
                        <td width='745' style='text-align: left; font: 700 '>
                        <p>
                            --<br/>
                            Kind regards<br>
                            System Administrator, <br>
                            <strong><a href='roomista.com'>roomista.com</a></strong>
                        </p>
                        <br/><br/><br/>
                        <hr/>
                        <span style='color:#CCC; font-size:10px; font-family:Arial, Helvetica, sans-serif;'>This e-mail is confidential. It may also be legally privileged. If you are not the intended recipient or have received it in error, please delete it and all copies from your system and notify the sender immediately by return e-mail. Any unauthorized reading, reproducing, printing or further dissemination of this e-mail or its contents is strictly prohibited and may be unlawful. Internet communications cannot be guaranteed to be timely, secure, error or virus-free. The sender does not accept liability for any errors or omissions.</span>
                        </td>
                    </tr>
                </table>";

        //Headers of PDF and e-mail
        $boundary = "XYZ-" . date("dmYis") . "-ZYX";

        $header = "--$boundary\r\n";
        $header .= "Content-Transfer-Encoding: 8bits\r\n";
        $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n\r\n"; //plain
        $header .= "$body\r\n";
        $header .= "--$boundary\r\n";
        $header .= "Content-Type: application/pdf; name=\"" . $filename . "\"\r\n";
        $header .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n";
        $header .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $header .= "$content\r\n";
        $header .= "--$boundary--\r\n";

        $header2 = "MIME-Version: 1.0\r\n";
        $header2 .= "From: Roomista.com\r\n";
        $header2 .= "Return-Path: booking@roomista.com\r\n";
        $header2 .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
        $header2 .= "$boundary\r\n";

        $mail->IsSMTP();

        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Port = 465; // set the SMTP port for the GMAIL server

        $mail->Username = "booking@roomista.com"; // GMAIL username
        $mail->Password = "ubU*u5RT"; // GMAIL password

        $mail->From = "booking@roomista.com";
        $mail->FromName = "Roomista.com";

        $mail->Subject = "Your reservation is completed through roomista.com";

        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        $mail->WordWrap = 50; // set word wrap

        $mail->MsgHTML($header);
        $mail->AddCustomHeader($header2);
        $mail->AddAddress('yahampath.manoj@gmail.com', 'manoj');
        // $mail->AddAddress($client_email, $client_name);
        //$mail->AddCC('booking@roomista.com');
        //$mail->AddCC('info@roomista.com');
        //$mail->AddAddress("seevali@weblook.com");

        $mail->IsHTML(true); // send as HTML

        if (!$mail->Send()) {
            echo "Mailer Error: --- " . $mail->ErrorInfo;
        } else {
            //If Payment Successed; delete session details of pre paid voucher
            //UNSET RESERVATION SESSION FIELDS
            unset($_SESSION['check_in_date']);
            unset($_SESSION['check_out_date']);
            unset($_SESSION['no_of_dates']);
            unset($_SESSION['reservation_id']);
            unset($_SESSION['total']);
            unset($_SESSION['no_of_room']);
            unset($_SESSION['hotel_room_type_id']);
            unset($_SESSION['room_rate']);
            unset($_SESSION['no_of_rooms']);
            unset($_SESSION['merchantreferenceno']);

            $_SESSION['reservation_status'] = 'completed';
            if (isset($_REQUEST['redirect_to'])) {
                header('Location: ' . $_REQUEST['redirect_to'] . "?resid=" . $merchantReferenceNo);
            } else {
                header('Location: /');
            }
            return 1;
            echo 1;
        }
    } else {
        $content = $pdf->Output('', 'I');
        $content = chunk_split(base64_encode($content));
    }
} catch (HTML2PDF_exception $e) {
    echo $e;
}
?>
<html>
    <head>
        <title>Reservation Voucher</title>
    </head>
</html>