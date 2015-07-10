<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");
    $Hotels = new Hotels();
    $MainCity = new MainCity();

    $queryString = $_REQUEST['queryString'];
    $queryString = str_replace("'", '&rsquo;', $queryString);
    $HotelsQuick_rows = $Hotels->quickSearchHotels($queryString);
    $MainCityQuick_rows = $MainCity->quickSearchMainCity($queryString);
    echo '<div class="searchtitle">Hotels</div>';
    if (count($HotelsQuick_rows) > 0) {
        for ($y = 0; $y < count($HotelsQuick_rows); $y++) {
            $Hotels->extractor($HotelsQuick_rows, $y);
            $MainCity->extractor($HotelsQuick_rows, $y);
            if ($Hotels->hotelsImages() != '') {
                $temp_arr = array();
                $temp_arr = explode(",", $Hotels->hotelsImages());
                $img_path = $temp_arr[0];
            } else {
                $img_path = "no-image.png";
            }

            echo '<a onClick="fill(\'' . trim($Hotels->hotelName()) . '\',\'' . trim($Hotels->hotelSeoUrl()) . '\',\'1\');"><div class="display_box">';
            //echo '<img src="uploads/hotels/'.$img_path.'" alt="" />';
            echo $Hotels->hotelName() . '</div></a>';
        }
    } else {
        //echo 'Hotels Not Found :(';
    }

    if (count($MainCityQuick_rows) > 0) {
        echo '<div class="searchtitle">Citys</div>';
        for ($r = 0; $r < count($MainCityQuick_rows); $r++) {
            $MainCity->extractor($MainCityQuick_rows, $r);

            echo '<a onClick="fill(\'' . trim($MainCity->mainCityName()) . '\',\'' . trim($MainCity->mainCitySeo()) . '\',\'2\');"><div class="display_box">';
            echo $MainCity->mainCityName() . '</div></a>';

        }
    } else {
        //echo '<span class="searchheading">Nothing interesting here? Try the sitemap.</span><br class="break" />';
    }

?>