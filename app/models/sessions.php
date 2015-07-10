<?php
    class Sessions {
       
		public function setMemberLoginSessions($id, $memberTitle, $memberFirstName, $memberLastName)
        {
			$_SESSION['member_is_logged'] = true;
            $_SESSION['login_member_id'] = $id;
            $_SESSION['member_fullname'] = $memberTitle . "&nbsp;" . $memberFirstName . "&nbsp;" . $memberLastName;
        }

        function getMemberId()
        {
            return isset($_SESSION['login_member_id']) ? $_SESSION['login_member_id'] : null;
        }

        function getMemberName()
        {
            return isset($_SESSION['member_fullname']) ? $_SESSION['member_fullname'] : null;
        }

        function logoutMember()
        {
			unset($_SESSION['member_is_logged']);
            unset($_SESSION['login_member_id']);
            unset($_SESSION['member_fullname']);
            unset($_SESSION['enable_back_end_agent_rate_view']);
            unset($_SESSION['enable_back_end_agent_spcl_disc_view']);
            unset($_SESSION['booked']);

        }

        function redirectIfNotLoggedInMember()
        {
			if (!$this->memberIsLogged()) {
                header("Location: " . HTTP_PATH . "register/?q=l");
            }

        }

        function memberIsLogged()
        {
            return isset($_SESSION['member_is_logged']) ? $_SESSION['member_is_logged'] : null;
        }

        function setClientLoginSessions($id, $clientTitle, $clientFirstName, $clientLastName)
        {
            $_SESSION['client_is_logged'] = true;
            $_SESSION['login_client_id'] = $id;
            $_SESSION['client_fullname'] = $clientTitle . "&nbsp;" . $clientFirstName . "&nbsp;" . $clientLastName;
        }

        function setSearchSessions($search_num_of_room, $search_adults, $search_children, $check_in_date, $check_out_date, $no_of_dates)
        {
            $_SESSION['search_num_of_room'] = $search_num_of_room;
            $_SESSION['search_adults'] = $search_adults;
            $_SESSION['search_children'] = $search_children;
            $_SESSION['check_in_date'] = $check_in_date;
            $_SESSION['check_out_date'] = $check_out_date;
            $_SESSION['no_of_dates'] = $no_of_dates;
        }

        function setCurrencySessions($currId, $currCode, $currPrefix, $currSuffix, $currValue, $path)
        {
            $_SESSION['curr_id'] = $currId;
            $_SESSION['currCode'] = $currCode;
            $_SESSION['currPrefix'] = $currPrefix;
            $_SESSION['currSuffix'] = $currSuffix;
            $_SESSION['currValue'] = $currValue;
            $_SESSION['ipLocation'] = $path;
        }

        function checkInDate()
        {
            return isset($_SESSION['check_in_date']) ? $_SESSION['check_in_date'] : null;
        }

        function checkOutDate()
        {
            return isset($_SESSION['check_out_date']) ? $_SESSION['check_out_date'] : null;
        }

        function searchNumOfRoom()
        {
            return isset($_SESSION['search_num_of_room']) ? $_SESSION['search_num_of_room'] : null;
        }

        function currId()
        {
            return isset($_SESSION['currId']) ? $_SESSION['currId'] : null;
        }

        function currCode()
        {
            return isset($_SESSION['currCode']) ? $_SESSION['currCode'] : null;
        }

        function currPrefix()
        {
            return isset($_SESSION['currPrefix']) ? $_SESSION['currPrefix'] : null;
        }

        function currSuffix()
        {
            return isset($_SESSION['currSuffix']) ? $_SESSION['currSuffix'] : null;
        }

        function currValue()
        {
            return isset($_SESSION['currValue']) ? $_SESSION['currValue'] : null;
        }

        function ipLocation()
        {
            return isset($_SESSION['ipLocation']) ? $_SESSION['ipLocation'] : null;
        }

        function getClientId()
        {
            return isset($_SESSION['login_client_id']) ? $_SESSION['login_client_id'] : null;
        }

        function getClientFullName()
        {
            return isset($_SESSION['client_fullname']) ? $_SESSION['client_fullname'] : null;
        }
		
        function setReservationsDetails($valArrey)
        {
            $_SESSION['valArrey'] = $valArrey;
        }

        function logoutClient()
        {

            unset($_SESSION['client_is_logged']);
            unset($_SESSION['client_fullname']);
            unset($_SESSION['login_client_id']);
            unset($_SESSION['enable_back_end_agent_rate_view']);

        }

        function redirectIfNotLoggedInClient()
        {

            if (!$this->clientIsLogged()) {
                header("Location: " . HTTP_PATH . "clients/?q=l");
            }

        }

        function clientIsLogged()
        {
            return isset($_SESSION['client_is_logged']) ? $_SESSION['client_is_logged'] : null;
        }

        function redirectIfNotLoggedInMemberOrHotels()
        {

            if (!$this->hotelsIsLogged() && !$this->memberIsLogged()) {
                header("Location: " . HTTP_PATH . "clients/?q=l");
            }

        }

        function hotelsIsLogged()
        {
            return isset($_SESSION['hotels_is_logged']) ? $_SESSION['hotels_is_logged'] : null;
        }

        function isSinhala()
        {
            if ($_SESSION['glb_lang'] == "sin") {
                return true;
            }else{
                return false;
            }
        }

        function isEnglish()
        {
            if ($_SESSION['glb_lang'] == "eng") {
                return true;
            } else {
                return false;
            }
        }

        function setHotelsLoginSessions($id, $name)
        {

            $_SESSION['hotels_is_logged'] = true;
            $_SESSION['login_hotels_id'] = $id;
            $_SESSION['login_hotels_name'] = $name;
        }

        function getHotelsId()
        {
            return isset($_SESSION['login_hotels_id']) ? $_SESSION['login_hotels_id'] : null;
        }

        function getHotelsName()
        {
            return isset($_SESSION['login_hotels_name']) ? $_SESSION['login_hotels_name'] : null;
        }

        function logoutHotels()
        {

            unset($_SESSION['hotels_is_logged']);
            unset($_SESSION['login_hotels_id']);
            unset($_SESSION['login_hotels_name']);
            unset($_SESSION['enable_back_end_agent_rate_view']);
            unset($_SESSION['online_payment_check_hotels_id']);

        }

        function redirectIfNotLoggedInHotels()
        {

            if (!$this->hotelsIsLogged()) {
                header("Location: " . HTTP_PATH . "login/");
            }

        }

        function setAdminLoginSessions($id, $name, $email)
        {

            $_SESSION['admin_is_logged'] = true;
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_name'] = $name;
            $_SESSION['admin_email'] = $email;

        }

        function getAdminId()
        {
            return isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;
        }

        function getAdminName()
        {
            return isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : null;
        }

        function getAdminEmail()
        {
            return isset($_SESSION['admin_email']) ? $_SESSION['admin_email'] : null;
        }

        function logoutAdmin()
        {

            unset($_SESSION['admin_is_logged']);
            unset($_SESSION['admin_id']);
            unset($_SESSION['admin_name']);
            unset($_SESSION['admin_email']);

        }

        function redirectAdminIfNotLoggedIn()
        {

            if (!$this->adminIsLogged()) {
                //header("Location: ".HTTP_PATH."admin/login.php");
            }

        }

        function adminIsLogged()
        {
            return isset($_SESSION['admin_is_logged']) ? $_SESSION['admin_is_logged'] : null;
        }

        /*client details passing*/

        function getOpenDateFrom($opendatefrom)
        {
            return isset($_SESSION['check_in_date']) ? $_SESSION['check_in_date'] : null;
        }

        function setOpenDateFrom($opendatefrom)
        {
            $_SESSION['check_in_date'] = $opendatefrom;
        }

        function getOpenDateTo($opendateto)
        {
            return isset($_SESSION['check_out_date']) ? $_SESSION['check_out_date'] : null;
        }

        function setOpenDateTo($opendateto)
        {
            $_SESSION['check_out_date'] = $opendateto;
        }

        function getBookRoomAdults($bookroomadults)
        {
            return isset($_SESSION['book_room_adults']) ? $_SESSION['book_room_adults'] : null;
        }

        function setBookRoomAdults($bookroomadults)
        {
            $_SESSION['book_room_adults'] = $bookroomadults;
        }

        function getBookRoomChildren($bookroomchildren)
        {
            return isset($_SESSION['book_room_children']) ? $_SESSION['book_room_children'] : null;
        }

        function setBookRoomChildren($bookroomchildren)
        {
            $_SESSION['book_room_children'] = $bookroomchildren;
        }

        function getRoomType()
        {
            return isset($_SESSION['room_type']) ? $_SESSION['room_type'] : null;
        }

        function setRoomType($roomtype)
        {
            $_SESSION['room_type'] = $roomtype;
        }

        function getHotelsIdView()
        {
            return isset($_SESSION['hotels_id']) ? $_SESSION['hotels_id'] : null;
        }

        function setHotelsIdView($hotels_id)
        {
            $_SESSION['hotels_id'] = $hotels_id;
        }

        function getBookRoom()
        {
            return isset($_SESSION['book_room']) ? $_SESSION['book_room'] : null;
        }

        function setBookRoom($bookroom)
        {
            $_SESSION['book_room'] = $bookroom;
        }

        function getCountry()
        {
            return isset($_SESSION['country_id']) ? $_SESSION['country_id'] : null;
        }

        function setCountry($countryid)
        {
            $_SESSION['country_id'] = $countryid;
        }

        function getRoomNum()
        {
            return isset($_SESSION['rc_num_of_rooms']) ? $_SESSION['rc_num_of_rooms'] : null;
        }

        function setRoomNum($rcnumrooms)
        {
            $_SESSION['rc_num_of_rooms'] = $rcnumrooms;
        }

        function getRoomBedType()
        {
            return isset($_SESSION['room_bed_type']) ? $_SESSION['room_bed_type'] : null;
        }

        function setRoomBedType($roombedtype)
        {
            $_SESSION['room_bed_type'] = $roombedtype;
        }

        function getRoomMealType()
        {
            return isset($_SESSION['room_meal_type']) ? $_SESSION['room_meal_type'] : null;
        }

        function setRoomMealType($roommealtype)
        {
            $_SESSION['room_meal_type'] = $roommealtype;
        }

        function getAmount()
        {
            return isset($_SESSION['amount']) ? $_SESSION['amount'] : null;
        }

        function setAmount($amount)
        {
            $_SESSION['amount'] = $amount;
        }

        function getMerchantReferenceNo()
        {
            return isset($_SESSION['merchantreferenceno']) ? $_SESSION['merchantreferenceno'] : null;
        }

        function setMerchantReferenceNo($merchantreferenceno)
        {
            $_SESSION['merchantreferenceno'] = $merchantreferenceno;
        }

        /*end client details passing*/

        function getLastMainCityId($cityid)
        {
            return isset($_SESSION['last_city_id']) ? $_SESSION['last_city_id'] : null;
        }

        function setLastMainCityId($cityid)
        {
            $_SESSION['last_city_id'] = $cityid;
        }

        function getLastSubCityId($cityid)
        {
            return isset($_SESSION['last_sub_city_id']) ? $_SESSION['last_sub_city_id'] : null;
        }

        function setLastSubCityId($cityid)
        {
            $_SESSION['last_sub_city_id'] = $cityid;
        }

        function setHotelImageUploadList($imglist)
        {
            $_SESSION['hotel_image_upload_list'] = $imglist;
        }

        function getHotelImageUploadList()
        {
            return isset($_SESSION['hotel_image_upload_list']) ? $_SESSION['hotel_image_upload_list'] : null;
        }

        function setUploadedLogo($uploaded_logo)
        {
            $_SESSION['set_uploaded_logo'] = $uploaded_logo;
        }

        function getUploadedLogo($uploaded_logo)
        {
            return isset($_SESSION['set_uploaded_logo']) ? $_SESSION['set_uploaded_logo'] : null;
        }

        function setRoomImage($uploaded_room_image)
        {
            $_SESSION['uploaded_room_image'] = $uploaded_room_image;
        }

        function getRoomImage()
        {
            return isset($_SESSION['uploaded_room_image']) ? $_SESSION['uploaded_room_image'] : null;
        }

        function setUploadedLogoUpdate($uploaded_logo)
        {
            $_SESSION['uploaded_logo_update'] = $uploaded_logo;
        }

        function getUploadedLogoUpdate($uploaded_logo)
        {
            return isset($_SESSION['uploaded_logo_update']) ? $_SESSION['uploaded_logo_update'] : null;
        }

        function setUploadedOfferImage($uploaded_image)
        {
            $_SESSION['uploaded_offer_image'] = $uploaded_image;
        }

        function getUploadedOfferImage()
        {
            return isset($_SESSION['uploaded_offer_image']) ? $_SESSION['uploaded_offer_image'] : null;
        }

        function setUploadedOfferImageUpdate($uploaded_image)
        {
            $_SESSION['uploaded_offer_image_update'] = $uploaded_image;
        }

        function getUploadedOfferImageUpdate()
        {
            return isset($_SESSION['uploaded_offer_image_update']) ? $_SESSION['uploaded_offer_image_update'] : null;
        }

        function setOnlinePaymentData($bedType, $mealType, $room_count, $rate, $check_in, $check_out, $roomTypeId, $hotels_id)
        {
            $_SESSION['booked'] = 'booked';
            $_SESSION['online_payment_bedType'] = $bedType;
            $_SESSION['online_payment_mealType'] = $mealType;
            $_SESSION['online_payment_room_count'] = $room_count;
            $_SESSION['online_payment_rate'] = $rate;
            $_SESSION['online_payment_check_in'] = $check_in;
            $_SESSION['online_payment_check_out'] = $check_out;
            $_SESSION['online_payment_check_room_type_Id'] = $roomTypeId;
            $_SESSION['online_payment_check_hotels_id'] = $hotels_id;
        }

        function setOnlinePaymentRate($rate)
        {
            $_SESSION['online_payment_rate'] = $rate;
        }

        function setDisplayRateIn($rate_in)
        {
            $_SESSION['display_rate_in'] = $rate_in;
        }

        function setOnlinePaymentRateWithCurrency($rate,$rate_in)
        {
            $_SESSION['online_payment_rate'] = $rate;
            $_SESSION['display_rate_in'] = $rate_in;
        }

        function setOnlinePaymentOffer($offer_data)
        {
            $_SESSION['online_payment_offer_available']=1;
            $_SESSION['online_payment_offer_data'] = $offer_data;
        }

        function resetOnlinePaymentOffer(){
            $_SESSION['online_payment_offer_available']=0;
            unset($_SESSION['online_payment_offer_data']);
        }

        function getOnlinePaymentOfferAvailable()
        {
            return isset($_SESSION['online_payment_offer_available']) ? $_SESSION['online_payment_offer_available'] : null;
        }

        function getOnlinePaymentOfferData()
        {
            return isset($_SESSION['online_payment_offer_data']) ? $_SESSION['online_payment_offer_data'] : null;
        }

        function getDisplayRatesIn()
        {
            return isset($_SESSION['display_rate_in']) ? $_SESSION['display_rate_in'] : null;
        }

        function getOnlinePaymentBedType()
        {
            return isset($_SESSION['online_payment_bedType']) ? $_SESSION['online_payment_bedType'] : null;
        }

        function getOnlinePaymentMealType()
        {
            return isset($_SESSION['online_payment_mealType']) ? $_SESSION['online_payment_mealType'] : null;
        }

        function getOnlinePaymentRoomCount()
        {
            return isset($_SESSION['online_payment_room_count']) ? $_SESSION['online_payment_room_count'] : null;
        }

        function getOnlinePaymentRate()
        {
            return isset($_SESSION['online_payment_rate']) ? $_SESSION['online_payment_rate'] : null;
        }

        function getOnlinePaymentCheckin()
        {
            return isset($_SESSION['online_payment_check_in']) ? $_SESSION['online_payment_check_in'] : null;
        }

        function getOnlinePaymentCheckout()
        {
            return isset($_SESSION['online_payment_check_out']) ? $_SESSION['online_payment_check_out'] : null;
        }

        function getOnlinePaymentRoomTypeId()
        {
            return isset($_SESSION['online_payment_check_room_type_Id']) ? $_SESSION['online_payment_check_room_type_Id'] : null;
        }

        function getOnlinePaymentHotelId()
        {
            return isset($_SESSION['online_payment_check_hotels_id']) ? $_SESSION['online_payment_check_hotels_id'] : null;
        }

        function setHotelRatesEditHotelId($hotel_id)
        {
            $_SESSION['hotel_rates_edit_hotel_id'] = $hotel_id;
        }

        function getHotelRatesEditHotelId()
        {
            return isset($_SESSION['hotel_rates_edit_hotel_id']) ? $_SESSION['hotel_rates_edit_hotel_id'] : null;
        }

        function setOnlinePaymentReservationId($res_id)
        {
            $_SESSION['online_payment_res_id'] = $res_id;
        }

        function getOnlinePaymentReservationId()
        {
            return isset($_SESSION['online_payment_res_id']) ? $_SESSION['online_payment_res_id'] : null;
        }

        function setEnableBackEndAgentRateView()
        {
            $_SESSION['enable_back_end_agent_rate_view'] = true;
        }

        function getEnableBackEndAgentRateView()
        {
            return isset($_SESSION['enable_back_end_agent_rate_view']) ? $_SESSION['enable_back_end_agent_rate_view'] : null;
        }

        function setEnableBackEndAgentSpclDiscountView()
        {
            $_SESSION['enable_back_end_agent_spcl_disc_view'] = true;
        }

        function getEnableBackEndAgentSpclDiscountView()
        {
            return isset($_SESSION['enable_back_end_agent_spcl_disc_view']) ? $_SESSION['enable_back_end_agent_spcl_disc_view'] : null;
        }

    }
