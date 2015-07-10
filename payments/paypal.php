<?php
    define('_MEXEC', 'OK');
    require_once("../system/load.php");

    $classHotel = new Hotels;
    $classReservation = new Reservations;
    //$classSite=new SITE;


    //unset($_SESSION['reservation_login']);

    /*if($_SESSION['check_in_date']==''){
        header('Location: ../index.php');
    }*/

    //$reservation_id=mysql_real_escape_string($_SESSION['reservation_id']);
    //$total=mysql_real_escape_string($_SESSION['total']);

    /*$getReservationDetailByIdCall=$classReservation->getReservationDetailById($reservation_id);
    $rowReservation=mysql_fetch_array($getReservationDetailByIdCall);*/

    /*$rowReceAddedHotImgMainCount=mysql_num_rows($classHotel->getHotelImagesByHotelId($rowReservation['hotel_id'],'',''));
    //hotel_id,limit,position
    $getHotelImagesByHotelIdCall=$classHotel->getHotelImagesByHotelId($rowReservation['hotel_id'],'',rand(1, $rowReceAddedHotImgMainCount));
    $rowReceAddedHotImgMain=mysql_fetch_array($getHotelImagesByHotelIdCall);*/


    /*
    if($_SESSION["curr_type_from_booking_page"]!="foreign"){

        $room_rate=($rowReservation['room_rate']/$rowReservation['curr_value']);

        $total=($rowReservation['total']/$rowReservation['curr_value']);

    }else{


        $room_rate=$rowReservation['room_rate'];

        $total=$rowReservation['total'];

    }*/
    //echo $total;

    /*$viewCurrencyByIdCall=$classSite->viewCurrencyById($rowReservation['curr_id']);
    $rowCurrlist=mysql_fetch_array($viewCurrencyByIdCall);	*/

    //echo $total;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>:: ::</title>

    <style type="text/css">
        <!--
        @import url("../styles/main.css");
        @import url("../styles/footer.css");
        -->
    </style>


    <!--dropdwn start -->
    <script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>

    <script src="../js/jquery-1.3.2.min.js" type="text/javascript"></script>
    <script src="../js/jquery.dd.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../styles/dd.css"/>
    <!--dropdwn end -->

    <!--read more start-->

    <script>
        $(document).ready(function () {

            $('a').click(function () {
                var divname = this.name;
                $("#" + divname).show("slow").siblings().hide("slow");
            });

        });
    </script>
    <!--read more end-->


</head>

<body>

<script language="javascript">
    $(document).ready(function (e) {
        try {
            $("#webmenu").msDropDown();
            $("#webmenu2").msDropDown();
        } catch (e) {
            alert(e.message);
        }
    });
</script>


<!--top area start-->
<div class="top-blue-bg-main">

    <?php require_once('../includes/top-links.php'); ?>


    <div class="top-blue-midle">


        <div class="register-text">

            Book The Hotel

        </div>



        <?php require_once('../includes/top-dropdown.php'); ?>





        <!--left area start-->

        <div class="hotel-left-area-main-wraper">

            <div class="hotel-booking-left-area-topic-main">Roomista Rewards Members</div>

            <div class="hotel-left-area1">

                <div class="hotel-booking-page-left-main">
                    Login now to redeem your rewards points <br/>
                    <input type="button" class="button1-hotel-booking" value="LOGIN"
                           onclick="javascript:login_member();"/>
                </div>
                <div class="hotel-left-larg-img-shadow"></div>


                <!--The room is available srat-->
                <div class="booking-page-left-text-11">
                    <img src="<?php echo HTTP_PATH; ?>images/hotels/right3.png" width="15"/>
                    <span class="red-text">The room is available.</span> We can only hold the room for the next 20
                    minutes.
                </div>
                <div class="hotel-left-larg-img-shadow"></div>
                <!--The room is available end-->


                <!--my fav hotels srat--><!--my fav hotels end-->


                <!--my latest viewd hotels srat--><!--my latest viewd hotels end-->


                <!--map srat--><!--map end-->


            </div>

        </div>

        <!--left area end-->


        <!--right area start-->

        <div class="hotel-name-text-wraper"></div>
        <!--<div class="hotel-adress-text-wraper">Samanthara Road, pothupitiya <a href="#">View Map</a></div>-->
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="payPalForm">

            <div class="hotel-right-area-main">
                <!--search start-->
                <div class="hotel-check-rates-title">Guest and Payment Details</div>

                <div class="hotel-check-rates-text-area">

                    <div class="hotel-top-search-area-main-inside-wraper5">Confirm Your Amount</div>
                    <div class="hotel-top-search-area-main-inside-wraper5"></div>
                    <div class="hotel-top-search-area-main-inside-wraper5">
                        <input type="text" name="amount" class="medium-input-logn" id="amount" style="width:150px;"
                               autocomplete="off" value="<?= number_format($total, 2); ?>"/> USD
                    </div>
                    <input type="hidden" name="item_number"
                           value="<?= "{$rowReservation['no_of_room']} - {$rowReservation['room_type_name']} at {$rowReservation['hotel_name']} for {$_SESSION['no_of_dates']} Days"; ?>">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="business" value="<?= $paypal_id; ?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="return"
                           value="<?= HTTP_PATH; ?>_controller?action=successPaymentReservation">

                    <input name="item_name" type="hidden" id="item_name"
                           value="Roomista.com :: <?= "{$rowReservation['no_of_room']} - {$rowReservation['room_type_name']} at {$rowReservation['hotel_name']} for {$_SESSION['no_of_dates']} Days"; ?>"
                           size="45">


                    <div class="hotel-top-search-insite-etxt-wraper-fr-all">
                        <input type="submit" class="button1-hotel" value="PAY NOW"/>
                    </div>


                </div>

                <!--search end--><!--room types strt-->
                <div class="hotel-check-rates-title">Booking Details</div>

                <div class="booking-page-main">

                    <div class="h-midle-area-top-img-main-rows-boxe-image"><img
                            src="../images/uploadImages/hotel_main/thumbnails/<?= $rowReceAddedHotImgMain['image_name']; ?>"
                            width="80" height="80"/>

                    </div>
                    <div class="booking-page-main-rows-text1">
                        <div class="booking-page-main-rows-text">
                            <?= no_magic_quotes($rowReservation['hotel_name']); ?>
                        </div>
                        <div class="booking-page-main-rows-text">
                            <div class="h-midle-area-recently-booked-start-wraper"></div>
                        </div>
                        <div class="booking-page-main-rows-text">
                            <span class="ash-text"><?= $rowReservation['room_type_name']; ?></span>
                        </div>
                        <div class="booking-page-main-rows-text">
                            <span class="ash-text"
                                  style="font-size:11px; color:#666; font-weight:normal;">Max <strong><?= $rowReservation['max_persons']; ?></strong> Adults&nbsp;&nbsp;Extra Beds <strong><?= $rowReservation['max_extra_beds']; ?></strong> Adults</span>
                            <br/>

                            <span
                                style="font-size:11px; font-weight:normal;">Reserved from <strong><?= $rowReservation['check_in_date']; ?></strong> to <strong><?= $rowReservation['check_out_date']; ?></strong></span>

                        </div>
                    </div>

                    <div class="hotel-booking-details-text-wraper">
                        <?= $rowReservation['check_in_date']; ?> - <?= $rowReservation['check_out_date']; ?> <span
                            class="blue-text"><?= $rowReservation['no_of_dates']; ?> Night(s)</span><br/>
                        No. of rooms : <span class="blue-text"><?= $rowReservation['no_of_room']; ?></span><br/>
                        Room charge (per night) :  <span class="blue-text">USD <?= number_format($room_rate, 2); ?><br/>
(<?= $rowCurrlist['curr_suffix']; ?> <?= number_format($room_rate * $rowCurrlist['curr_value_selling'], 2); ?>
                            )</span><br/><br/>
                        Total Amount :  <span class="blue-text" style="font-size:22px;">
USD <?= number_format($total, 2); ?><br/>
<span
    style="font-size:14px;"><?= $rowCurrlist['curr_suffix']; ?> <?= number_format($total * $rowCurrlist['curr_value_selling'], 2); ?></span><br/>
</span>

                    </div>

                    <div class="hotel-booking-details-text-wraper2">

                        <input type="submit" class="button1-hotel" value="PAY NOW" style="float:right;"/>


                        <div class="menu">

                        </div>
                    </div>


                    <!--show more start-->

                    <!--show more end-->


                </div>
                <!--room types end-->


            </div>

        </form>

        <!--right area end-->


    </div>

</div>
<!--top area end-->


<!--midle boxes area start-->

<div class="midle-area-main">
    <div class="midle-area-midle">


    </div>
</div>


<!--midle boxes area end-->


<!--bottom serch area  start-->

<div class="bottom-search-main-wraper">
    <?php require_once('../includes/bottom-subscribe.php'); ?>
</div>

<!--bottom serch area  end-->


<!--bottom links area start-->

<div class="bottom-links-main">
    <div class="bottom-links-midle">
        <?php require_once('../includes/bottom-links.php'); ?>
    </div>
</div>

<!--bottom links area end-->


<!--footer start-->

<?php require_once('../includes/footer.php'); ?>

<!--footer end-->


</body>
</html>