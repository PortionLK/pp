<?php

    class Hotels
    {

        private $hotel_id;
        private $hotel_member_id;
        private $hotel_country_id;
        private $hotel_main_city_id;
        private $hotel_sub_city_id;
        private $hotel_category_id;
        private $hotel_name;
        private $hotel_name_in_other;
        private $hotel_address;
        private $hotel_post_code;
        private $hotel_phone;
        private $hotel_fax;
        private $hotel_email;
        private $hotel_password;
        private $hotel_web;
        private $hotel_accommodation_type;
        private $hotel_rating;
        private $hotel_rooms;
        private $hotel_discount_values;
        private $hotel_payment_status;
        private $hotel_active_status;
        private $hotel_description;
        private $hotel_features;
        private $hotel_checkin_time;
        private $hotel_checkin_suffix;
        private $hotel_checkout_time;
        private $hotel_checkout_suffix;
        private $hotel_profile_completion;
        private $hotel_geo_location;
        private $hotel_airport_transport_availability;
        private $hotel_airport_transport_fee;
        private $hotel_distance_from_city;
        private $hotel_seo_url;
        private $hotel_meta_description;
        private $hotel_meta_keyword;
        private $hotel_hits;
        private $hotel_posision;
        private $hotels_featured_status;
        private $hotels_lastlogin_time;
        private $hotels_lastlogin_count;
        private $hotel_registered_date;
        private $hotels_images;

        private $table_name = "hotels";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;
            $this->settings = array(
                "password_encryption_type" => "md5",
            );

        }

        function hotelNameInOther()
        {
            return $this->hotel_name_in_other;
        }

        function hotelPassword()
        {
            return $this->hotel_password;
        }

        function hotelPaymentStatus()
        {
            return $this->hotel_payment_status;
        }

        function hotelProfileCompletion()
        {
            return $this->hotel_profile_completion;
        }

        function hotelGeoLocation()
        {
            return $this->hotel_geo_location;
        }

        function hotelMetaDescription()
        {
            return $this->hotel_meta_description;
        }

        function hotelMetaKeyword()
        {
            return $this->hotel_meta_keyword;
        }

        function hotelHits()
        {
            return $this->hotel_hits;
        }

        function hotelPosision()
        {
            return $this->hotel_posision;
        }

        function hotelsLastloginTime()
        {
            return $this->hotels_lastlogin_time;
        }

        function hotelsLastloginCount()
        {
            return $this->hotels_lastlogin_count;
        }

        function hotelRegisteredDate()
        {
            return $this->hotel_registered_date;
        }

        function extractor($results, $row = 0)
        {
            $this->setHotelId($results[$row]['hotel_id']);
            $this->setHotelMemberId($results[$row]['hotel_member_id']);
            $this->setHotelCountryId($results[$row]['hotel_country_id']);
            $this->setHotelMainCityId($results[$row]['hotel_main_city_id']);
            $this->setHotelSubCityId($results[$row]['hotel_sub_city_id']);
            $this->setHotelCategoryId($results[$row]['hotel_category_id']);
            $this->setHotelName($results[$row]['hotel_name']);
            $this->setHotelNameInOther($results[$row]['hotel_name_in_other']);
            $this->setHotelAddress($results[$row]['hotel_address']);
            $this->setHotelPostCode($results[$row]['hotel_post_code']);
            $this->setHotelPhone($results[$row]['hotel_phone']);
            $this->setHotelFax($results[$row]['hotel_fax']);
            $this->setHotelEmail($results[$row]['hotel_email']);
            $this->setHotelPassword($results[$row]['hotel_password']);
            $this->setHotelWeb($results[$row]['hotel_web']);
            $this->setHotelAccommodationType($results[$row]['hotel_accommodation_type']);
            $this->setHotelRating($results[$row]['hotel_rating']);
            $this->setHotelRooms($results[$row]['hotel_rooms']);
            $this->setHotelDiscountValues($results[$row]['hotel_discount_values']);
            $this->setHotelPaymentStatus($results[$row]['hotel_payment_status']);
            $this->setHotelActiveStatus($results[$row]['hotel_active_status']);
            $this->setHotelDescription($results[$row]['hotel_description']);
            $this->setHotelFeatures($results[$row]['hotel_features']);
            $this->setHotelCheckinTime($results[$row]['hotel_checkin_time']);
            //$this->setHotelCheckinSuffix($results[$row]['hotel_checkin_suffix']);
            $this->setHotelCheckoutTime($results[$row]['hotel_checkout_time']);
            //$this->setHotelCheckoutSuffix($results[$row]['hotel_checkout_suffix']);
            $this->setHotelProfileCompletion($results[$row]['hotel_profile_completion']);
            $this->setHotelGeoLocation($results[$row]['hotel_geo_location']);
            $this->setHotelAirportTransportAvailability($results[$row]['hotel_airport_transport_availability']);
            $this->setHotelAirportTransportFee($results[$row]['hotel_airport_transport_fee']);
            $this->setHotelDistanceFromCity($results[$row]['hotel_distance_from_city']);
            $this->setHotelSeoUrl($results[$row]['hotel_seo_url']);
            $this->setHotelMetaDescription($results[$row]['hotel_meta_description']);
            $this->setHotelMetaKeyword($results[$row]['hotel_meta_keyword']);
            $this->setHotelHits($results[$row]['hotel_hits']);
            $this->setHotelPosision($results[$row]['hotel_posision']);
            $this->setHotelsFeaturedStatus($results[$row]['hotels_featured_status']);
            $this->setHotelsLastloginTime($results[$row]['hotels_lastlogin_time']);
            $this->setHotelsLastloginCount($results[$row]['hotels_lastlogin_count']);
            $this->setHotelRegisteredDate($results[$row]['hotel_registered_date']);
            $this->setHotelsImages($results[$row]['hotels_images']);
//       $this->setHotelSevenDayDiscountLoaclValues($results[$row]['hotels_seven_day_discount_local']);
//       $this->setHotelSevenDayDiscountForiegnValues($results[$row]['hotels_seven_day_discount_foriegn']);
        }

        function setHotelId($hotel_id)
        {
            $this->hotel_id = $hotel_id;
        }

        function setHotelMemberId($hotel_member_id)
        {
            $this->hotel_member_id = $hotel_member_id;
        }

        function setHotelCountryId($hotel_country_id)
        {
            $this->hotel_country_id = $hotel_country_id;
        }

        function setHotelMainCityId($hotel_main_city_id)
        {
            $this->hotel_main_city_id = $hotel_main_city_id;
        }

        function setHotelSubCityId($hotel_sub_city_id)
        {
            $this->hotel_sub_city_id = $hotel_sub_city_id;
        }

        function setHotelCategoryId($hotel_category_id)
        {
            $this->hotel_category_id = $hotel_category_id;
        }

        function setHotelName($hotel_name)
        {
            $this->hotel_name = $hotel_name;
        }

        function setHotelNameInOther($hotel_name_in_other)
        {
            $this->hotel_name_in_other = $hotel_name_in_other;
        }

        function setHotelAddress($hotel_address)
        {
            $this->hotel_address = $hotel_address;
        }

        function setHotelPostCode($hotel_post_code)
        {
            $this->hotel_post_code = $hotel_post_code;
        }

        function setHotelPhone($hotel_phone)
        {
            $this->hotel_phone = $hotel_phone;
        }

        function setHotelFax($hotel_fax)
        {
            $this->hotel_fax = $hotel_fax;
        }

        function setHotelEmail($hotel_email)
        {
            $this->hotel_email = $hotel_email;
        }

        function setHotelPassword($hotel_password)
        {
            $this->hotel_password = $hotel_password;
        }

        function setHotelWeb($hotel_web)
        {
            $this->hotel_web = $hotel_web;
        }

        function setHotelAccommodationType($hotel_accommodation_type)
        {
            $this->hotel_accommodation_type = $hotel_accommodation_type;
        }

        function setHotelRating($hotel_rating)
        {
            $this->hotel_rating = $hotel_rating;
        }

        function setHotelRooms($hotel_rooms)
        {
            $this->hotel_rooms = $hotel_rooms;
        }

        function setHotelDiscountValues($hotel_discount_values)
        {
            $this->hotel_discount_values = $hotel_discount_values;
        }

        function setHotelPaymentStatus($hotel_payment_status)
        {
            $this->hotel_payment_status = $hotel_payment_status;
        }

        function setHotelActiveStatus($hotel_active_status)
        {
            $this->hotel_active_status = $hotel_active_status;
        }

        function setHotelDescription($hotel_description)
        {
            $this->hotel_description = $hotel_description;
        }

        function setHotelFeatures($hotel_features)
        {
            $this->hotel_features = $hotel_features;
        }

        function setHotelCheckinTime($hotel_checkin_time)
        {
            $this->hotel_checkin_time = $hotel_checkin_time;
        }

//        function setHotelCheckinSuffix($hotel_checkin_suffix)
//        {
//            $this->hotel_checkin_suffix = $hotel_checkin_suffix;
//        }

        function setHotelCheckoutTime($hotel_checkout_time)
        {
            $this->hotel_checkout_time = $hotel_checkout_time;
        }

//        function setHotelCheckoutSuffix($hotel_checkout_suffix)
//        {
//            $this->hotel_checkout_suffix = $hotel_checkout_suffix;
//        }

        function setHotelProfileCompletion($hotel_profile_completion)
        {
            $this->hotel_profile_completion = $hotel_profile_completion;
        }

        //------------------------//

        function setHotelGeoLocation($hotel_geo_location)
        {
            $this->hotel_geo_location = $hotel_geo_location;
        }

        function setHotelAirportTransportAvailability($hotel_airport_transport_availability)
        {
            $this->hotel_airport_transport_availability = $hotel_airport_transport_availability;
        }

        function setHotelAirportTransportFee($hotel_airport_transport_fee)
        {
            $this->hotel_airport_transport_fee = $hotel_airport_transport_fee;
        }

        function setHotelDistanceFromCity($hotel_distance_from_city)
        {
            $this->hotel_distance_from_city = $hotel_distance_from_city;
        }

        function setHotelSeoUrl($hotel_seo_url)
        {
            $this->hotel_seo_url = $hotel_seo_url;
        }

        function setHotelMetaDescription($hotel_meta_description)
        {
            $this->hotel_meta_description = $hotel_meta_description;
        }

        function setHotelMetaKeyword($hotel_meta_keyword)
        {
            $this->hotel_meta_keyword = $hotel_meta_keyword;
        }

        function setHotelHits($hotel_hits)
        {
            $this->hotel_hits = $hotel_hits;
        }

        function setHotelPosision($hotel_posision)
        {
            $this->hotel_posision = $hotel_posision;
        }

        function setHotelsFeaturedStatus($hotels_featured_status)
        {
            $this->hotels_featured_status = $hotels_featured_status;
        }

        function setHotelsLastloginTime($hotels_lastlogin_time)
        {
            $this->hotels_lastlogin_time = $hotels_lastlogin_time;
        }

        function setHotelsLastloginCount($hotels_lastlogin_count)
        {
            $this->hotels_lastlogin_count = $hotels_lastlogin_count;
        }

        function setHotelRegisteredDate($hotel_registered_date)
        {
            $this->hotel_registered_date = $hotel_registered_date;
        }

        function setHotelsImages($hotels_images)
        {
            $this->hotels_images = $hotels_images;
        }

        function addHotelFirstTime()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "hotel_member_id"          => $this->hotelMemberId(),
                "hotel_country_id"         => $this->hotelCountryId(),
                "hotel_main_city_id"       => $this->hotelMainCityId(),
                "hotel_sub_city_id"        => $this->hotelSubCityId(),
                "hotel_category_id"        => $this->hotelCategoryId(),
                "hotel_description"        => $this->hotelDescription(),
                "hotel_name"               => $this->hotelName(),
                "hotel_address"            => $this->hotelAddress(),
                "hotel_post_code"          => $this->hotelPostCode(),
                "hotel_phone"              => $this->hotelPhone(),
                "hotel_fax"                => $this->hotelFax(),
                "hotel_email"              => $this->hotelEmail(),
                "hotel_password"           => $this->settings["password_encryption_type"]($this->hotelEmail()),
                "hotel_web"                => $this->hotelWeb(),
                "hotel_accommodation_type" => $this->hotelAccommodationType(),
                "hotel_rating"             => $this->hotelRating(),
                "hotel_rooms"              => $this->hotelRooms(),
                "hotel_discount_values"    => $this->hotelDiscountValues(),
                "hotel_payment_status"     => 0,
                "hotel_active_status"      => 0,
                "hotels_featured_status"   => 0,
                "hotel_registered_date"    => COUNTRY_DATE,
                "hotels_images"            => $this->hotelsImages(),
                "hotel_seo_url"            => $this->hotelSeoUrl()
            ));
            return $this->MDatabase->insert_id();

        }

        function hotelMemberId()
        {
            return $this->hotel_member_id;
        }

        function hotelCountryId()
        {
            return $this->hotel_country_id;
        }

        function hotelMainCityId()
        {
            return $this->hotel_main_city_id;
        }

        function hotelSubCityId()
        {
            return $this->hotel_sub_city_id;
        }

        function hotelCategoryId()
        {
            return $this->hotel_category_id;
        }

        function hotelDescription()
        {
            return $this->hotel_description;
        }

        function hotelName()
        {
            return $this->hotel_name;
        }

        function hotelAddress()
        {
            return $this->hotel_address;
        }

        function hotelPostCode()
        {
            return $this->hotel_post_code;
        }

        function hotelPhone()
        {
            return $this->hotel_phone;
        }

        function hotelFax()
        {
            return $this->hotel_fax;
        }

        function hotelEmail()
        {
            return $this->hotel_email;
        }

        function hotelWeb()
        {
            return $this->hotel_web;
        }

        function hotelAccommodationType()
        {
            return $this->hotel_accommodation_type;
        }

        function hotelRating()
        {
            return $this->hotel_rating;
        }

        function hotelRooms()
        {
            return $this->hotel_rooms;
        }

        function hotelDiscountValues()
        {
            return $this->hotel_discount_values;
        }

        function hotelsImages()
        {
            return $this->hotels_images;
        }

        function hotelSeoUrl()
        {
            return $this->hotel_seo_url;
        }

        function editHotelFirst()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "hotel_country_id"         => $this->hotelCountryId(),
                "hotel_main_city_id"       => $this->hotelMainCityId(),
                "hotel_sub_city_id"        => $this->hotelSubCityId(),
                "hotel_description"        => $this->hotelDescription(),
                "hotel_name"               => $this->hotelName(),
                "hotel_address"            => $this->hotelAddress(),
                "hotel_post_code"          => $this->hotelPostCode(),
                "hotel_phone"              => $this->hotelPhone(),
                "hotel_fax"                => $this->hotelFax(),
                "hotel_email"              => $this->hotelEmail(),
                "hotel_web"                => $this->hotelWeb(),
                "hotel_accommodation_type" => $this->hotelAccommodationType(),
                "hotel_rating"             => $this->hotelRating(),
                "hotel_rooms"              => $this->hotelRooms(),
                "hotel_discount_values"    => $this->hotelDiscountValues(),
                "hotel_seo_url"            => $this->hotelSeoUrl()
            ), array("hotel_id" => $this->hotelId()));
            return $status;

        }

        function hotelId()
        {
            return $this->hotel_id;
        }

        function updateHotelsStep_1()
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "hotel_category_id" => $this->hotelCategoryId(),
                "hotel_description" => $this->hotelDescription()
            ), array("hotel_id" => $this->hotelId()));
            return $status;

        }

        function updateHotelsStep_2()
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "hotel_features" => $this->hotelFeatures(),
            ), array("hotel_id" => $this->hotelId()));

            return $status;

        }

        function hotelFeatures()
        {
            return $this->hotel_features;
        }

        function updateHotelsStep_4()
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "hotel_airport_transport_availability" => $this->hotelAirportTransportAvailability(),
                "hotel_airport_transport_fee"          => $this->hotelAirportTransportFee(),
                "hotel_checkin_time"                   => $this->hotelCheckinTime(),
                //"hotel_checkin_suffix"                 => $this->hotelCheckinSuffix(),
                "hotel_checkout_time"                  => $this->hotelCheckoutTime(),
                //"hotel_checkout_suffix"                => $this->hotelCheckoutSuffix(),
                "hotel_distance_from_city"             => $this->hotelDistanceFromCity(),
            ), array("hotel_id" => $this->hotelId()));

            return $status;

        }

        function hotelAirportTransportAvailability()
        {
            return $this->hotel_airport_transport_availability;
        }

        function hotelAirportTransportFee()
        {
            return $this->hotel_airport_transport_fee;
        }

        function hotelCheckinTime()
        {
            return $this->hotel_checkin_time;
        }

//        function hotelCheckinSuffix()
//        {
//            return $this->hotel_checkin_suffix;
//        }

        //TODO: Add Hotel First Time

        function hotelCheckoutTime()
        {
            return $this->hotel_checkout_time;
        }

//        function hotelCheckoutSuffix()
//        {
//            return $this->hotel_checkout_suffix;
//        }

        function hotelDistanceFromCity()
        {
            return $this->hotel_distance_from_city;
        }

        function updateHotelsImages($imgs)
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "hotels_images" => $imgs,
            ), array("hotel_id" => $this->hotelId()));

            return $status;

        }

        function getAllHotelsPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*",  "hotel_active_status <> '" . Libs::getKey("hotel_status_admin", "Deactivated") . "'", "hotel_id DESC", $page);
            return $this->MDatabase->result;
        }

        function getHotelsBySearchPaginated($page,$search_str)
        {
            $this->MDatabase->selectJOIN($this->table_name, "*", "hotel_name LIKE '%" . $search_str . "%' AND hotel_active_status <> '" . Libs::getKey("hotel_status_admin", "Deactivated") . "'", "hotel_name DESC", $page);
            return $this->MDatabase->result;
        }

        function getPendingDeactivationHotelsPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*",  "hotel_active_status = '" . Libs::getKey("hotel_status_admin", "Deactivation Pending") . "'", "hotel_id DESC", $page);
            return $this->MDatabase->result;
        }

        function getDeactivatedHotelsPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*",  "hotel_active_status = '" . Libs::getKey("hotel_status_admin", "Deactivated") . "'", "hotel_id DESC", $page);
            return $this->MDatabase->result;
        }

        function getAllHotelsCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "hotel_active_status <> '" . Libs::getKey("hotel_status_admin", "Deactivated") . "'");
            return $this->MDatabase->result;
        }

        function getSearchedHotelsCount($search_str)
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "hotel_name LIKE '%" . $search_str . "%' AND hotel_active_status <> " . Libs::getKey("hotel_status_admin", "Deactivated") . "'", "");
            return $this->MDatabase->result;
        }

        function getPendingDeactivationHotelsCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "hotel_active_status = " . Libs::getKey("hotel_status_admin", "Deactivation Pending") );
            return $this->MDatabase->result;
        }

        function getDeactivatedHotelsCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "hotel_active_status = " . Libs::getKey("hotel_status_admin", "Deactivated") );
            return $this->MDatabase->result;
        }

        function getAllHotelsWithDiscountFront($page)
        {
            $this->MDatabase->rowsPerPage = 3;
            $this->MDatabase->select($this->table_name, "*", "hotel_discount_values >='15' AND hotel_active_status='1'", "hotel_name", $page);
            //$this->MDatabase->select($this->table_name,"*","hotel_discount_values >='15' AND hotel_active_status='1' ","hotel_name",$page);
            return $this->MDatabase->result;
        }

        function getAllHotelsWithSpecialOffersFront($page)
        {
            $this->MDatabase->rowsPerPage = 10;
            $this->MDatabase->selectJOIN($this->table_name . " INNER JOIN special_offers ON special_offers.hotel_id=hotels.hotel_id", "*", "(('" . date('Y-m-d') . "' BETWEEN from_date AND to_date) OR (from_date >= '" . date('Y-m-d') . "')) AND hotels.hotel_active_status='1' AND special_offers.status='0'", "hotel_name", $page);
            return $this->MDatabase->result;
        }

        function getAllHotelsDiscountCountFront()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "hotel_discount_values >='15'", "", $page);
            return $this->MDatabase->result;
        }

        function getAllHotelsWithOffersCountFront()
        {
            $this->MDatabase->selectJOIN($this->table_name . " INNER JOIN special_offers ON special_offers.hotel_id=hotels.hotel_id","COUNT(*) as count", "(('" . date('Y-m-d') . "' BETWEEN from_date AND to_date) OR (from_date >= '" . date('Y-m-d') . "')) AND hotels.hotel_active_status='1' AND special_offers.status='0'", "","");
            return $this->MDatabase->result;
        }

        function getAllHotels()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_active_status='1'", "");
            return $this->MDatabase->result;
        }

        function selectDataFromRoomType($roomTypeId)
        {
            $this->MDatabase->select("room_rates", "*", "room_rate_id = " . $roomTypeId . "", "");
            return $this->MDatabase->result;
        }

        function checkAllRoomsTypesAdded($hotel_room_type_id)
        {
            $this->MDatabase->select("room_rates", "*", "hotel_room_type_id = " . $hotel_room_type_id . "", "");
            if ($this->MDatabase->result) {
                return " display:none; ";
            }

        }

        function checkAllRoomsTypesAvalable($hotel_room_type_id)
        {
            $this->MDatabase->select("room_rates", "*", "hotel_room_type_id = " . $hotel_room_type_id . "", "");
            return $this->MDatabase->result;
        }

        function getHotelFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_id='" . $this->hotelId() . "'");
            //echo $this->MDatabase->sqlquery; die();
            return $this->MDatabase->result;
        }

        function getHotelFromMemberId()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_member_id='" . $this->hotelMemberId() . "' AND (hotel_active_status<>3)");
            return $this->MDatabase->result;
        }

        function getHotelFromEmailID()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_email='" . $this->hotelEmail() . "'");
            //echo $this->MDatabase->sqlquery; die();
            return $this->MDatabase->result;
        }

        function getHotelIdFromSeoName()
        {
            $this->MDatabase->select($this->table_name, "hotel_id", "hotel_seo_url='" . $this->hotelSeoUrl() . "'");
            $res = $this->MDatabase->result;
            return $res[0]["hotel_id"];
        }

        function getHotelFromMainCityId()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_main_city_id='" . $this->hotelMainCityId() . "' AND hotel_active_status='1'");
            return $this->MDatabase->result;
        }

        function getHotelFromSubCityId()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_sub_city_id='" . $this->hotelSubCityId() . "' AND hotel_active_status='1'");
            return $this->MDatabase->result;
        }

        function getHotelFromFeaturedStatus()
        {
            $this->MDatabase->select($this->table_name, "*", "hotels_featured_status='1' AND hotel_active_status='1'", "hotel_id DESC LIMIT 0,3");
            //echo $this->MDatabase->sqlquery;
			return $this->MDatabase->result;
        }

        function getHotelRecentlyAdd()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_active_status='1'", "hotel_id DESC LIMIT 0,6");
            return $this->MDatabase->result;
        }

        function getAllHotelsWithDiscount()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_discount_values >='15' AND hotel_active_status='1' ", "hotel_id DESC");
            return $this->MDatabase->result;
        }

        function getLowestRate(){
            $cols="MIN(LEAST(COALESCE(NULLIF(sgl_ro_sell_foriegn,0), 2147483647),COALESCE(NULLIF(dbl_ro_sell_foriegn,0), 2147483647),COALESCE(NULLIF(tpl_ro_sell_foriegn,0), 2147483647) ,COALESCE(NULLIF(sgl_bb_sell_foriegn,0), 2147483647),COALESCE(NULLIF(dbl_bb_sell_foriegn,0), 2147483647),COALESCE(NULLIF(tpl_bb_sell_foriegn,0), 2147483647),COALESCE(NULLIF(sgl_hb_sell_foriegn,0), 2147483647),COALESCE(NULLIF(dbl_hb_sell_foriegn,0), 2147483647),COALESCE(NULLIF(tpl_hb_sell_foriegn,0), 2147483647),COALESCE(NULLIF(sgl_fb_sell_foriegn,0), 2147483647),COALESCE(NULLIF(dbl_fb_sell_foriegn,0), 2147483647),COALESCE(NULLIF(tpl_fb_sell_foriegn,0), 2147483647))) MinRate";
            $this->MDatabase->selectJOIN("room_rates INNER JOIN hotels ON hotels.hotel_id= room_rates.hotel_id", $cols, "room_rates.hotel_id='".$this->hotelId()."' AND hotel_active_status='".Libs::getKey("hotel_status_admin", "Active")."' AND COALESCE(NULLIF(sgl_ro_sell_foriegn,0), NULLIF(dbl_ro_sell_foriegn,0),NULLIF(tpl_ro_sell_foriegn,0), NULLIF(sgl_bb_sell_foriegn,0),NULLIF(dbl_bb_sell_foriegn,0), NULLIF(tpl_bb_sell_foriegn,0),NULLIF(sgl_hb_sell_foriegn,0), NULLIF(dbl_hb_sell_foriegn,0),NULLIF(tpl_hb_sell_foriegn,0), NULLIF(sgl_fb_sell_foriegn,0),NULLIF(dbl_fb_sell_foriegn,0), NULLIF(tpl_fb_sell_foriegn,0)) IS NOT NULL", "");
            $res = $this->MDatabase->result;
            $amount = $res[0]["MinRate"];
            $response= array("RateAvailable" => ($amount <>''? true : false), "Rate" => ($amount <>''? $amount : 0));
            return $response;

        }

        function isHotelEmailExists()
        {
            $hotel_email = '';
            $hotel_email = $this->hotelEmailEqual();

            if ($hotel_email != $this->hotelEmail()) {
                $this->MDatabase->select($this->table_name, "COUNT(*)", "hotel_email='" . $this->hotelEmail() . "'");
                $res = $this->MDatabase->result;
                if ($res[0]["COUNT(*)"] >= 1) {
                    return "false";
                }else {
                    return "true";
                }
            } else {
                return "true";
            }
        }

        function isSeoUrlExists()
        {
            $seo_url = '';
            $seo_url = $this->seoUrlEqual();

            if ($seo_url != $this->HotelSeoUrl()) {
                $this->MDatabase->select($this->table_name, "COUNT(*)", "hotel_seo_url='" . $this->HotelSeoUrl() . "'");
                $res = $this->MDatabase->result;
                if ($res[0]["COUNT(*)"] >= 1) {
                    return "false";
                }else {
                    return "true";
                }
            } else {
                return "true";
            }
        }

        function hotelEmailEqual()
        {
            $this->MDatabase->select($this->table_name, "hotel_email", "hotel_id=" . $this->hotelId() . "");
            $res2 = $this->MDatabase->result;
            if ($res2)
                return $eml = $res2[0]["hotel_email"];
            else
                return '';
        }

        function seoUrlEqual()
        {
            $this->MDatabase->select($this->table_name, "hotel_seo_url", "hotel_id=" . $this->hotelId() . "");
            $res2 = $this->MDatabase->result;
            if ($res2)
                return $eml = $res2[0]["hotel_seo_url"];
            else
                return '';
        }

        function deleteHotel()
        {
            $data = $this->hotelRoomTypes();

            $status = $this->MDatabase->delete($this->table_name, "hotel_id='" . $this->hotelId() . "'");
            $status = $this->MDatabase->delete("hotel_room_types", "room_type_id='" . $data[0]['room_type_id'] . "'");
            $status = $this->MDatabase->delete("room_rates", "hotel_room_type_id='" . $data[0]['room_type_id'] . "'");
            $status = $this->MDatabase->delete("room_control", "rc_room_type_id='" . $data[0]['room_type_id'] . "'");

            return $status;
        }

        function changeHotelActiveStatus()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "hotel_active_status" => $this->hotelActiveStatus()
            ), array("hotel_id" => $this->hotelId()));
            return $status;
        }

        function hotelRoomTypes()
        {
            $this->MDatabase->select("hotel_room_types", "*", "room_type_hotel_id = '" . $this->hotelId() . "'");
            return $this->MDatabase->result;
        }

        function updateHotelStatus()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "hotel_active_status" => $this->hotelActiveStatus()
            ), array("hotel_id" => $this->hotelId()));
            return $status;
        }

        function hotelActiveStatus()
        {
            return $this->hotel_active_status;
        }

        function updateFeaturedStatus()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "hotels_featured_status" => $this->hotelsFeaturedStatus()
            ), array("hotel_id" => $this->hotelId()));
            return $status;
        }

        function hotelsFeaturedStatus()
        {
            return $this->hotels_featured_status;
        }

        function quickSearchHotels($queryString)
        {

            $temp = explode(" ", $queryString);
            $temp2 = array();

            foreach ($temp as $k => $v) {
                array_push($temp2, "%" . $v . "%");
            }

            $queryString = implode($temp2);
            $spl_1 = split(' ', $queryString);

            for ($i = 0; $i < count($spl_1); $i++) {
                $mainSql1 .= "'%" . $spl_1[$i] . "%' ";
            }

            $this->MDatabase->selectJOIN($this->table_name . ",main_city,sub_city",
                "hotel_id,hotel_main_city_id,hotel_sub_city_id,
                 hotel_name,sub_city_id,main_city_id,sub_city_name,main_city_name,hotels_images,hotel_seo_url,main_city_seo ", "hotel_active_status='1' AND
																	hotel_main_city_id=main_city_id AND 
                                                                    hotel_sub_city_id=sub_city_id AND
                                                                   ( hotel_name LIKE " . $mainSql1 . " OR
																	main_city_name LIKE " . $mainSql1 . " OR
																	sub_city_name LIKE " . $mainSql1 . ")", "hotel_id DESC LIMIT 0,100");
            //echo $this->MDatabase->sqlquery; die();
            return $this->MDatabase->result;
        }

        function setValues($data)
        {

            foreach ($data as $k => $v) {
                $this->$k = $v;
            }

        }

    }

?>