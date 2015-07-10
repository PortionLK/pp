<?php

    class Common
    {

        static function jsonEncode($code, $msg)
        {
            $array = array(
                "code" => $code,
                "msg"  => $msg
            );

            echo json_encode($array);
        }

        static function jsonEncodeData($array)
        {
            echo json_encode($array);
        }

        static function jsonSuccess($msg, $href = "")
        {
            if ($href == "") {
                echo json_encode(array("code" => "200", "msg" => $msg));
            } else {
                echo json_encode(array("code" => "200", "msg" => $msg, "href" => $href));
            }
        }

        static function jsonSuccessMessage($msg)
        {
            echo json_encode(array("code" => "201", "msg" => $msg));
        }

        static function jsonSuccessNoMessage($data)
        {
            echo json_encode(array("code" => "202", "msg" => $data));
        }

        static function jsonError($msg)
        {
            echo json_encode(array("code" => "400", "msg" => $msg));
        }

        //showErrorsForCapture

        static function jsonValidationError($msg, $elements)
        {
            echo json_encode(array("code" => "303", "msg" => $msg, "els" => $elements));
        }

        static function formatDate($timestamp)
        {
            if ($timestamp != "" && $timestamp != 0) {
                return date("F j, Y", $timestamp);
            } else {
                return "-";
            }
        }

        static function currURL()
        {
            return (!empty($_SERVER['HTTPS'])) ? "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }

        static function textToSQLLikeString($data)
        {

            $data_arr = explode(" ", $data);

            $final_string = "";

            foreach ($data_arr as $k => $v) {

                $final_string .= "%";

                if ($v != "") {
                    $final_string .= "$v";
                }

                if (($k + 1) == count($data_arr)) {
                    $final_string .= "%";
                }

            }

            return $final_string;
        }

        static function CSVExport($results)
        {

            header("Content-type:text/octect-stream");
            header("Content-Disposition:attachment;filename=data.csv");

            for ($i = 0; $i < count($results); $i++) {
                print '"' . stripslashes(implode('","', $results[$i])) . "\"\n";
            }

            exit;
        }

        static function currencyConvert($from, $to, $value)
        {

            //Old Version

            $amount = urlencode($value);
            $from_Currency = urlencode($from);
            $to_Currency = urlencode($to);

            $url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";

            $ch = curl_init();
            $timeout = 0;
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt ($ch, CURLOPT_USERAGENT,
                "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $rawdata = curl_exec($ch);
            curl_close($ch);
            $data = explode('bld>', $rawdata);
            $data = explode($to_Currency, $data[1]);

            return round($data[0], 2);

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

//            $amount = urlencode($value);
//            $from_Currency = urlencode($from);
//            $to_Currency = urlencode($to);
//
//            $url = "http://rate-exchange.appspot.com/currency?from=".$from_Currency."&to=".$to_Currency."&q=".$amount;
//
//            $ch = curl_init();
//            $timeout = 0;
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//
//            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
//            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//            $rawdata = curl_exec($ch);
//            curl_close($ch);
//            $data = json_decode($rawdata);
//            return round($data->{'v'}, 2);
        }

        static function countries_array()
        {
            $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
            return $countries;
        }

        static function createDateRangeArray($strDateFrom, $strDateTo)
        {
            // takes two dates formatted as YYYY-MM-DD and creates an
            // inclusive array of the dates between the from and to dates.
            $aryRange = array();
            if($strDateFrom<>"" && $strDateTo <>"") {
                $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
                $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
                if ($iDateTo >= $iDateFrom) {
                    array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
                    while ($iDateFrom < $iDateTo) {
                        $iDateFrom += 86400; // add 24 hours
                        array_push($aryRange, date('Y-m-d', $iDateFrom));
                    }
                }
            }
            return $aryRange;
        }
    }