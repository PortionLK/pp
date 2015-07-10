<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $path = $_REQUEST['path'];
    if ($path == 'member') {
        $Sessions = new Sessions();
        $hotel = new Hotels();
        $hotel->setHotelId($_REQUEST['id']);
        $hotel->extractor($hotel->getHotelFromId());
        unset($_SESSION['HTTP_PATH_SESSION']);
        $Sessions->logoutClient();
        $Sessions->logoutHotels();
        $Sessions->setMemberLoginSessions($hotel->memberId());
        $_SESSION['HTTP_PATH_SESSION'] = HTTP_PATH;
        if (!$Sessions->redirectIfNotLoggedInMember()) {
            echo "true";
        }
    }
    if ($path == 'client') {
        $Sessions = new Sessions();
        $members = new Members();
        $members->setMemberId($_REQUEST['id']);
        $members->extractor($members->getMemberFromId());
        unset($_SESSION['HTTP_PATH_SESSION']);
        $Sessions->logoutClient();
        $Sessions->logoutMember();
        $Sessions->setHotelsLoginSessions($hotel->hotelId());
        $_SESSION['HTTP_PATH_SESSION'] = HTTP_PATH;
        if (!$Sessions->redirectIfNotLoggedInHotels()) {
            echo "true";
        }
    }
    if ($path == 'hotels') {

        $Sessions = new Sessions();
        $hotel = new Hotels();
        $hotel->setHotelId($_REQUEST['id']);
        $hotel->extractor($hotel->getHotelFromId());
        unset($_SESSION['HTTP_PATH_SESSION']);
        $Sessions->logoutClient();
        $Sessions->logoutMember();
        $Sessions->setHotelsLoginSessions($hotel->hotelId());
        $_SESSION['HTTP_PATH_SESSION'] = HTTP_PATH;
        if (!$Sessions->redirectIfNotLoggedInHotels()) {
            echo "true";
        }

        $Sessions->setEnableBackEndAgentRateView();
        $Sessions->setEnableBackEndAgentSpclDiscountView();

    }
?>