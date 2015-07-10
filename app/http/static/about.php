<?php
    define('_MEXEC', 'OK');
    require_once("system/load.php");

    $mainCity = new MainCity();
    $hotels = new Hotels();
    $country = new country();
    $SubCity = new SubCity();
    $hotelimages = new HotelImages();

    $mainCity_row = $mainCity->getMainCityFromHomePage();
    $mainCity_list = $mainCity->getMainCity();
    $hotels_row = $hotels->getHotelFromFeaturedStatus();
    $hotelsRecently_row = $hotels->getHotelRecentlyAdd();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Roomista</title>
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/style.css" type="text/css" media="screen"/>
    <!-- <link rel="shortcut icon" href="<?php echo HTTP_PATH; ?>images/favicon.ico">
<link rel="icon" type="image/ico" href="<?php echo HTTP_PATH; ?>images/favicon.ico">-->

    <!--[if IE]>
    <link href="<?php echo HTTP_PATH; ?>css/ie.css" rel="stylesheet" type="text/css"/>

    <link rel="shortcut icon" href="<?php echo HTTP_PATH; ?>favicon.ico">
    <link rel="icon" type="image/ico" href="<?php echo HTTP_PATH; ?>favicon.ico">

    <![endif]-->

    <!--[if IE 7]>
    <link href="<?php echo HTTP_PATH; ?>css/ie7.css" rel="stylesheet" type="text/css"/>
    <![endif]-->

    <!--[if IE 8]>
    <link href="<?php echo HTTP_PATH; ?>css/ie8.css" rel="stylesheet" type="text/css"/>
    <![endif]-->

    <!--[if IE 9]>
    <link href="<?php echo HTTP_PATH; ?>css/ie9.css" rel="stylesheet" type="text/css"/>
    <![endif]-->

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery.jcarousel.min.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="system/js/hotels.js"></script>
    <script type="text/javascript">

        jQuery(document).ready(function () {
            jQuery('#mycarousel').jcarousel();
        });

    </script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#accordion").accordion();
        });
    </script>

</head>
<body>
<div id="wrapper">
    <?php include(DOC_ROOT . 'includes/header.php'); ?>
</div>
<!--end header-inner-->

<div id="content">
    <div class="content-inner">
        <?php include(DOC_ROOT . 'includes/hotel-catgories-inner.php'); ?>
        <div class="mid-sec">
            <div class="mid_container_left"><img src="images/srilanka.jpg" width="350" height="376"/></div>
            <div class="mid_container">
                <h2> About Us</h2>

                <p>As fashionistas keep an eye on the hottest trends in the world of fashion we divert our attention to
                    the roomistas who loves to explore the world beyond the horizon taking sanctuary in uniquely
                    designed hotels and accommodative spaces.
                    Welcome to Roomistas! Where the discerning business travellers, leisure travellers and holidaying
                    expatriates find the best safe haven adorned in roomy comforts. </p>


                <h3> Our Corporate Identity</h3>

                <p>We are here to serve the great travelling spirit in you, and our mark says it all. </p>

                <ul>
                    <li>It is the numeric value that depicts our standard, and our supremacy in the Hotel industry.</li>
                    <li>The letter "R" of Roomista is for YOU, Our valued customers who are courageous enough to explore
                        new worlds and experience the luxuriance ambience of different safe havens. This online space is
                        just for roomistas like you.
                    </li>
                    <li>The bow tie, which denotes our specialization in the hotel industry, and the characteristics of
                        a faithful servant who is ready to fulfil your accommodative desires.
                    </li>
                </ul>

                <p>The further you go the more you realize that there is more out there apart from your home, office and
                    friends places. Travelling revives you, to look into situations with different perspectives, to open
                    minds and warmly inviting knowledge in. Therefore it is our duty to assist you in your aspirations
                    by keeping you warm and seductively pampered for a reasonable value, allowing you to discover the
                    world with more money and more time. </p>

                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <!--end mid-sec-->





        <?php include(DOC_ROOT . 'includes/whyroomista-subscribe.php'); ?>




        <div class="clear"></div>
    </div>
    <!--end content-inner-->
    <div class="clear"></div>
</div>
<!--end content-->
<?php include(DOC_ROOT . 'includes/footer.php'); ?>
<div class="clear"></div>
</div>
<!--end wrapper-->
<div class="clear"></div>
</body>
</html>
