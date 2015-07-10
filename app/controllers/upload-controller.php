<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "uploadDestination":
            uploadBanner('destinations/');
            break;
        case "uploadDestinationUpload":
            uploadBannerUpdate('destinations/');
            break;
        case "uploadTourType":
            uploadBanner('tourtypes/');
            break;
        case "uploadTourTypeUpdate":
            uploadBannerUpdate('tourtypes/');
            break;
        case "uploadMainCity":
            uploadBanner('main-city/');
            break;
        case "uploadMainCityUpload":
            uploadBannerUpdate('main-city/');
            break;
        case "uploadNews":
            uploadBanner('news/');
            break;
        case "uploadNewsUpload":
            uploadBannerUpdate('news/');
            break;
        case "uploadTourMap":
            uploadBanner('tours/map/');
            break;
        case "uploadTourMapUpload":
            uploadBannerUpdate('tours/map/');
            break;
        case "uploadRoomImage":
            uploadRoomImage('room/');
            break;
        case "uploadRoomImageEdit":
            uploadRoomImageEdit('room/');
            break;
        case "directBookingImage":
            directBookingImage('direct-booking-images/');
            break;
        case "uploadOfferImage":
            uploadOfferImage('special_offers/');
            break;

    }

    function uploadBanner($path)
    {

        $pic = $_FILES['pic'];

        $upload_dir = DOC_ROOT . 'uploads/' . $path;

        $new_name = "roomista" . time() . "." . get_extension($pic['name']);

        Sessions::setUploadedLogo($new_name);

        if (move_uploaded_file($pic['tmp_name'], $upload_dir . $new_name)) {

            echo "done";

        }

    }

    function uploadRoomImage($path)
    {

        $pic = $_FILES['pic'];

        $upload_dir = DOC_ROOT . 'uploads/' . $path;

        $new_name = "roomista" . time() . "." . get_extension($pic['name']);

        Sessions::setRoomImage($new_name);

        if (move_uploaded_file($pic['tmp_name'], $upload_dir . $new_name)) {

            echo "done";

        }

    }

    function uploadRoomImageEdit($path)
    {
        $pic = $_FILES['pic'];
        echo $pic;
        $upload_dir = DOC_ROOT . 'uploads/' . $path;

        $new_name = "roomista" . time() . "." . get_extension($pic['name']);

        Sessions::setRoomImage($new_name);

        if (move_uploaded_file($pic['tmp_name'], $upload_dir . $new_name)) {

            echo "done";

        }

    }

    function uploadBannerUpdate($path)
    {

        $pic = $_FILES['pic_edit'];

        $upload_dir = DOC_ROOT . 'uploads/' . $path;

        $new_name = "roomista" . time() . "." . get_extension($pic['name']);

        Sessions::setUploadedLogoUpdate($new_name);

        if (move_uploaded_file($pic['tmp_name'], $upload_dir . $new_name)) {

            echo "done";

        }

    }

    function directBookingImage($path)
    {

        $pic = $_FILES['pic'];
        $hotels_id = $_REQUEST['hotel_id'];

        $upload_dir = DOC_ROOT . 'uploads/' . $path;

        $new_name = "header-" . $hotels_id . "." . get_extension($pic['name']);

        Sessions::setUploadedLogo($new_name);

        if (move_uploaded_file($pic['tmp_name'], $upload_dir . $new_name)) {

            echo "done";

        }

    }

    function uploadOfferImage($path)
    {
        $pic = $_FILES['pic'];
        $hotels_id = $_REQUEST['hotel_id'];

        $upload_dir = DOC_ROOT . 'uploads/' . $path;

        $new_name = "offer_" . $hotels_id . "_" . time() . "." . get_extension($pic['name']);

        Sessions::setUploadedOfferImage($new_name);

        if (move_uploaded_file($pic['tmp_name'], $upload_dir . $new_name)) {

            echo "done";
//            echo $_FILES['pic']['error'];

        }
        //else{
//            die($_FILES['pic']['error']);
//        }

    }

    function get_extension($file_name)
    {
        $ext = explode('.', $file_name);
        $ext = array_pop($ext);
        return strtolower($ext);
    }

?>