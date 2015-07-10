<?php

    class Reservations
    {

        private $reservation_id;
        private $reservation_client_id;
        private $reservation_hotel_id;
        private $reservation_hotel_room_type_id;
        private $reservation_bed_type;
        private $reservation_meal_type;
        private $reservation_no_of_room;
        private $reservation_room_rate_local;
        private $reservation_room_rate_foriegn;
        private $reservation_room_rate;
        private $reservation_total_price;
        private $currency_type;
        private $reservation_check_in_date;
        private $reservation_check_out_date;
        private $reservation_no_of_dates;
        private $reservation_payment_method;
        private $reservation_payment_status;
        private $reservation_reservation_status;
        private $reservation_from_booking_link;
        private $reservation_offer_available;
        private $reservation_offer_data;

        private $table_name = "reservations";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function extractor($results, $row = 0)
        {

            $this->setReservationId($results[$row]['reservation_id']);
            $this->setReservationClientId($results[$row]['reservation_client_id']);
            $this->setReservationHotelId($results[$row]['reservation_hotel_id']);
            $this->setReservationHotelRoomTypeId($results[$row]['reservation_hotel_room_type_id']);
            $this->setReservationBedType($results[$row]['reservation_bed_type']);
            $this->setReservationMealType($results[$row]['reservation_meal_type']);
            $this->setReservationNoOfRoom($results[$row]['reservation_no_of_room']);
            $this->setReservationRoomRateLocal($results[$row]['reservation_room_rate_local']);
            $this->setReservationRoomRateForiegn($results[$row]['reservation_room_rate_foriegn']);
            $this->setReservationRoomRate($results[$row]['reservation_room_rate']);
            $this->setReservationTotalPrice($results[$row]['reservation_total_price']);
            $this->setCurrencyType($results[$row]['currency_type']);
            $this->setReservationCheckInDate($results[$row]['reservation_check_in_date']);
            $this->setReservationCheckOutDate($results[$row]['reservation_check_out_date']);
            $this->setReservationNoOfDates($results[$row]['reservation_no_of_dates']);
            $this->setReservationPaymentMethod($results[$row]['reservation_payment_method']);
            $this->setReservationPaymentStatus($results[$row]['reservation_payment_status']);
            $this->setReservationReservationStatus($results[$row]['reservation_reservation_status']);
            $this->setReservationFromBookingLink($results[$row]['reservation_from_booking_link']);
            $this->setReservationOfferAvailable($results[$row]['reservation_offer_available']);
            $this->setReservationOfferData($results[$row]['reservation_offer_data']);

        }

        function setReservationId($reservation_id)
        {
            $this->reservation_id = $reservation_id;
        }

        function setReservationClientId($reservation_client_id)
        {
            $this->reservation_client_id = $reservation_client_id;
        }

        function setReservationHotelId($reservation_hotel_id)
        {
            $this->reservation_hotel_id = $reservation_hotel_id;
        }

        function setReservationHotelRoomTypeId($reservation_hotel_room_type_id)
        {
            $this->reservation_hotel_room_type_id = $reservation_hotel_room_type_id;
        }

        function setReservationBedType($reservation_bed_type)
        {
            $this->reservation_bed_type = $reservation_bed_type;
        }

        function setReservationMealType($reservation_meal_type)
        {
            $this->reservation_meal_type = $reservation_meal_type;
        }

        function setReservationNoOfRoom($reservation_no_of_room)
        {
            $this->reservation_no_of_room = $reservation_no_of_room;
        }

        function setReservationRoomRateLocal($reservation_room_rate_local)
        {
            $this->reservation_room_rate_local = $reservation_room_rate_local;
        }

        function setReservationRoomRateForiegn($reservation_room_rate_foriegn)
        {
            $this->reservation_room_rate_foriegn = $reservation_room_rate_foriegn;
        }

        function setReservationRoomRate($reservation_room_rate)
        {
            $this->reservation_room_rate = $reservation_room_rate;
        }

        function setReservationTotalPrice($reservation_total_price)
        {
            $this->reservation_total_price = $reservation_total_price;
        }

        function setCurrencyType($currency_type)
        {
            $this->currency_type = $currency_type;
        }

        function setReservationCheckInDate($reservation_check_in_date)
        {
            $this->reservation_check_in_date = $reservation_check_in_date;
        }

        function setReservationCheckOutDate($reservation_check_out_date)
        {
            $this->reservation_check_out_date = $reservation_check_out_date;
        }

        function setReservationNoOfDates($reservation_no_of_dates)
        {
            $this->reservation_no_of_dates = $reservation_no_of_dates;
        }

        function setReservationPaymentMethod($reservation_payment_method)
        {
            $this->reservation_payment_method = $reservation_payment_method;
        }

        function setReservationPaymentStatus($reservation_payment_status)
        {
            $this->reservation_payment_status = $reservation_payment_status;
        }

        //------------------------//

        function setReservationReservationStatus($reservation_reservation_status)
        {
            $this->reservation_reservation_status = $reservation_reservation_status;
        }

        function setReservationFromBookingLink($reservation_from_booking_link)
        {
            $this->reservation_from_booking_link = $reservation_from_booking_link;
        }

        function setReservationOfferAvailable($reservation_offer_available)
        {
            $this->reservation_offer_available = $reservation_offer_available;
        }

        function setReservationOfferData($reservation_offer_data)
        {
            $this->reservation_offer_data = $reservation_offer_data;
        }

        function newReservations()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "reservation_client_id"          => $this->reservationClientId(),
                "reservation_hotel_id"           => $this->reservationHotelId(),
                "reservation_hotel_room_type_id" => $this->reservationHotelRoomTypeId(),
                "reservation_bed_type"           => $this->reservationBedType(),
                "reservation_meal_type"          => $this->reservationMealType(),
                "reservation_no_of_room"         => $this->reservationNoOfRoom(),
                "reservation_room_rate_local"    => $this->reservationRoomRateLocal(),
                "reservation_room_rate_foriegn"  => $this->reservationRoomRateForiegn(),
                "reservation_room_rate"          => $this->reservationRoomRate(),
                "reservation_total_price"        => $this->reservationTotalPrice(),
                "currency_type"                  => $this->currencyType(),
                "reservation_check_in_date"      => $this->reservationCheckInDate(),
                "reservation_check_out_date"     => $this->reservationCheckOutDate(),
                "reservation_no_of_dates"        => $this->reservationNoOfDates(),
                "reservation_payment_method"     => $this->reservationPaymentMethod(),
                "reservation_payment_status"     => $this->reservationPaymentStatus(),
                "reservation_reservation_status" => $this->reservationReservationStatus(),
                "reservation_from_booking_link"  => $this->reservationFromBookingLink(),
                "reservation_offer_available"  => $this->reservationOfferAvailable(),
                "reservation_offer_data"  => $this->reservationOfferData(),
            ));

            //return $this->MDatabase->insert_id();
            return $status;

        }

        function reservationClientId()
        {
            return $this->reservation_client_id;
        }

        function reservationHotelId()
        {
            return $this->reservation_hotel_id;
        }

        function reservationHotelRoomTypeId()
        {
            return $this->reservation_hotel_room_type_id;
        }

        function reservationBedType()
        {
            return $this->reservation_bed_type;
        }

        function reservationMealType()
        {
            return $this->reservation_meal_type;
        }

        function reservationNoOfRoom()
        {
            return $this->reservation_no_of_room;
        }

        function reservationRoomRateLocal()
        {
            return $this->reservation_room_rate_local;
        }

        function reservationRoomRateForiegn()
        {
            return $this->reservation_room_rate_foriegn;
        }

        function reservationRoomRate()
        {
            return $this->reservation_room_rate;
        }

        function reservationTotalPrice()
        {
            return $this->reservation_total_price;
        }

        function currencyType()
        {
            return $this->currency_type;
        }

        function reservationCheckInDate()
        {
            return $this->reservation_check_in_date;
        }

        function reservationCheckOutDate()
        {
            return $this->reservation_check_out_date;
        }

        function reservationNoOfDates()
        {
            return $this->reservation_no_of_dates;
        }

        function reservationPaymentMethod()
        {
            return $this->reservation_payment_method;
        }

        function reservationPaymentStatus()
        {
            return $this->reservation_payment_status;
        }

        function reservationReservationStatus()
        {
            return $this->reservation_reservation_status;
        }

        function reservationFromBookingLink()
        {
            return $this->reservation_from_booking_link;
        }

        function reservationOfferAvailable()
        {
            return $this->reservation_offer_available;
        }

        function reservationOfferData()
        {
            return $this->reservation_offer_data;
        }

        function updateReservations()
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "reservation_client_id"          => $this->reservationClientId(),
                "reservation_hotel_id"           => $this->reservationHotelId(),
                "reservation_hotel_room_type_id" => $this->reservationHotelRoomTypeId(),
                "reservation_bed_type"           => $this->reservationBedType(),
                "reservation_meal_type"          => $this->reservationMealType(),
                "reservation_no_of_room"         => $this->reservationNoOfRoom(),
                "reservation_room_rate_local"    => $this->reservationRoomRateLocal(),
                "reservation_room_rate_foriegn"  => $this->reservationRoomRateForiegn(),
                "reservation_room_rate"          => $this->reservationRoomRate(),
                "reservation_total_price"        => $this->reservationTotalPrice(),
                "currency_type"                  => $this->currencyType(),
                "reservation_check_in_date"      => $this->reservationCheckInDate(),
                "reservation_check_out_date"     => $this->reservationCheckOutDate(),
                "reservation_no_of_dates"        => $this->reservationNoOfDates(),
                "reservation_payment_method"     => $this->reservationPaymentMethod(),
                "reservation_payment_status"     => $this->reservationPaymentStatus(),
                "reservation_reservation_status" => $this->reservationReservationStatus(),
                "reservation_from_booking_link"  => $this->reservationFromBookingLink(),
                "reservation_offer_available"  => $this->reservationOfferAvailable(),
                "reservation_offer_data"  => $this->reservationOfferData(),
            ), array("reservation_id" => $this->reservationId()));

            return $status;

        }

        function reservationId()
        {
            return $this->reservation_id;
        }

        function getAllReservationsPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAllReservationsCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "", "", $page);
            return $this->MDatabase->result;
        }

        function getReservationsFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "reservation_id='" . $this->reservationId() . "'");
            return $this->MDatabase->result;
        }

        function getReservationsFromClientId()
        {
            $this->MDatabase->select($this->table_name, "*", "reservation_client_id='" . $this->reservationClientId() . "'");
            return $this->MDatabase->result;
        }

        function getReservationsFromHotelId()
        {
            $this->MDatabase->select($this->table_name, "*", "reservation_hotel_id='" . $this->reservationHotelId() . "'");
            return $this->MDatabase->result;
        }

        function updateReservationsOnlinePayment()
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "reservation_payment_status" => $this->reservationPaymentStatus()
            ), array("reservation_id" => $this->reservationId()));

            return $status;

        }

        function deleteReservations()
        {
            $status = $this->MDatabase->delete($this->table_name, "reservation_id='" . $this->reservationId() . "'");
            return $status;
        }

        function setValues($data)
        {

            foreach ($data as $k => $v) {
                $this->$k = $v;
            }

        }

    }

?>