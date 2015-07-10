<?php
    define('_MEXEC', 'OK');
    require_once("system/includes/mainconfig.php");
    //require_once("system/load.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Roomista</title>
    <link rel="stylesheet" href="<?php echo HTTP_PATH; ?>css/style.css" type="text/css"/>
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
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/includes/js-config.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/main.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/members.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/reservations.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_PATH; ?>system/js/jquery.validate.js"></script>
</head>
<body>
<div id="wrapper">
    <?php include(DOC_ROOT . 'includes/header_error.php'); ?>
</div>
<!--end header-inner-->
<div id="content">
    <div class="content-inner">
        <?php //include(DOC_ROOT . 'includes/hotel-catgories-inner.php'); ?>
        <!--end mid-sec-->
        <div class="mid-sec" style="min-height: 550px !important;">
            <div class="left-col-wrap" style="width:550px; margin-left:250px;">
                <div class="form-title">
                    <h3 style="font-size: 16pt; color: #eb2f30">Sorry for the inconvenience.</h3>
                    <span class="title-block"></span>
                </div>
                <div class="booking-detail">

                    <ul>
                        <li style="text-align: center;">
                            <div style="display: none; font-size: 25pt; font-weight: bolder; padding-bottom: 30px; letter-spacing: 5px; ">:-(</div>
                            <div style="font-size: 16pt; line-height: 25px; ">Unable to connect to the Database server,We are currently Fixing the Issue.</div>
                            <div style="display: none; font-size: 16pt; line-height: 25px; ">Database server encountered a problem and failed to connect.This will be resolved shortly</div>
                        </li>
                    </ul>

            </div>
        </div>

        <!--end befor-footer-->
        <div class="clear"></div>
    </div>

</div>

</div>
<!--end wrapper-->
<div class="clear"></div>
</body>
</html>
