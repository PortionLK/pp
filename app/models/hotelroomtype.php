<?php

    class  HotelRoomType
    {

        private $room_type_id;
        private $room_type_hotel_id;
        private $room_type_name;
        private $room_type_max_persons;
        private $room_type_max_extra_beds;
        private $room_type_no_of_rooms;
        private $room_type_no_of_rooms_assign;
        private $room_type_features;
        private $room_type_img;

        private $table_name = "hotel_room_types";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function extractor($results, $row = 0)
        {

            $this->setRoomTypeId($results[$row]['room_type_id']);
            $this->setRoomTypeHotelId($results[$row]['room_type_hotel_id']);
            $this->setRoomTypeName($results[$row]['room_type_name']);
            $this->setRoomTypeMaxPersons($results[$row]['room_type_max_persons']);
            $this->setRoomTypeMaxExtraBeds($results[$row]['room_type_max_extra_beds']);
            $this->setRoomTypeNoOfRooms($results[$row]['room_type_no_of_rooms']);
            $this->setRoomTypeNoOfRoomsAssign($results[$row]['room_type_no_of_rooms_assign']);
            $this->setRoomTypeFeatures($results[$row]['room_type_features']);
            $this->setRoomTypeImg($results[$row]['room_type_img']);

        }

        function setRoomTypeId($room_type_id)
        {
            $this->room_type_id = $room_type_id;
        }

        function setRoomTypeHotelId($room_type_hotel_id)
        {
            $this->room_type_hotel_id = $room_type_hotel_id;
        }

        function setRoomTypeName($room_type_name)
        {
            $this->room_type_name = $room_type_name;
        }

        function setRoomTypeMaxPersons($room_type_max_persons)
        {
            $this->room_type_max_persons = $room_type_max_persons;
        }

        function setRoomTypeMaxExtraBeds($room_type_max_extra_beds)
        {
            $this->room_type_max_extra_beds = $room_type_max_extra_beds;
        }

        function setRoomTypeNoOfRooms($room_type_no_of_rooms)
        {
            $this->room_type_no_of_rooms = $room_type_no_of_rooms;
        }

        function setRoomTypeNoOfRoomsAssign($room_type_no_of_rooms_assign)
        {
            $this->room_type_no_of_rooms_assign = $room_type_no_of_rooms_assign;
        }

        //------------------------//

        function setRoomTypeFeatures($room_type_features)
        {
            $this->room_type_features = $room_type_features;
        }

        function setRoomTypeImg($room_type_img)
        {
            $this->room_type_img = $room_type_img;
        }

        function newHotelRoomType()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "room_type_hotel_id"           => $this->roomTypeHotelId(),
                "room_type_name"               => $this->roomTypeName(),
                "room_type_max_persons"        => $this->roomTypeMaxPersons(),
                "room_type_max_extra_beds"     => $this->roomTypeMaxExtraBeds(),
                "room_type_no_of_rooms"        => $this->roomTypeNoOfRooms(),
                "room_type_no_of_rooms_assign" => $this->roomTypeNoOfRoomsAssign(),
                "room_type_features"           => $this->roomTypeFeatures(),
                "room_type_img"                => $this->roomTypeImg()
            ));
            return $status;
        }

        function roomTypeHotelId()
        {
            return $this->room_type_hotel_id;
        }

        function roomTypeName()
        {
            return $this->room_type_name;
        }

        function roomTypeMaxPersons()
        {
            return $this->room_type_max_persons;
        }

        function roomTypeMaxExtraBeds()
        {
            return $this->room_type_max_extra_beds;
        }

        function roomTypeNoOfRooms()
        {
            return $this->room_type_no_of_rooms;
        }

        function roomTypeNoOfRoomsAssign()
        {
            return $this->room_type_no_of_rooms_assign;
        }

        function roomTypeFeatures()
        {
            return $this->room_type_features;
        }

        function roomTypeImg()
        {
            return $this->room_type_img;
        }

        function updateHotelRoomType()
        {

            $data = $this->getHotelRoomTypeFromId();
            $imageName = $data[0]['room_type_img'];

            if ($this->roomTypeImg() == "") {
                $status = $this->MDatabase->update($this->table_name, array(
                    "room_type_hotel_id"           => $this->roomTypeHotelId(),
                    "room_type_name"               => $this->roomTypeName(),
                    "room_type_max_persons"        => $this->roomTypeMaxPersons(),
                    "room_type_max_extra_beds"     => $this->roomTypeMaxExtraBeds(),
                    "room_type_no_of_rooms"        => $this->roomTypeNoOfRooms(),
                    "room_type_no_of_rooms_assign" => $this->roomTypeNoOfRoomsAssign(),
                    "room_type_features"           => $this->roomTypeFeatures()
                ), array("room_type_id" => $this->roomTypeId()));
            } else {

                $imgpath = DOC_ROOT . "uploads/room/" . $imageName;
                unlink($imgpath);

                $status = $this->MDatabase->update($this->table_name, array(
                    "room_type_hotel_id"           => $this->roomTypeHotelId(),
                    "room_type_name"               => $this->roomTypeName(),
                    "room_type_max_persons"        => $this->roomTypeMaxPersons(),
                    "room_type_max_extra_beds"     => $this->roomTypeMaxExtraBeds(),
                    "room_type_no_of_rooms"        => $this->roomTypeNoOfRooms(),
                    "room_type_no_of_rooms_assign" => $this->roomTypeNoOfRoomsAssign(),
                    "room_type_features"           => $this->roomTypeFeatures(),
                    "room_type_img"                => $this->roomTypeImg()
                ), array("room_type_id" => $this->roomTypeId()));
            }
            return $status;

        }

        function getHotelRoomTypeFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "room_type_id='" . $this->roomTypeId() . "'");
            return $this->MDatabase->result;
        }

        function roomTypeId()
        {
            return $this->room_type_id;
        }

        function getAllHotelRoomTypePaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAllHotelRoomTypeCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "", "", $page);
            return $this->MDatabase->result;
        }

        function getHotelRoomTypeFromHotelRoomtypeId($hotel_id, $roomId)
        {
            $this->MDatabase->select($this->table_name, "*", "room_type_hotel_id='" . $hotel_id . "' AND room_type_id='" . $roomId . "'");
            return $this->MDatabase->result;
        }

        function getHotelRoomTypeFromHotelsId()
        {
            $this->MDatabase->select($this->table_name, "*", "room_type_hotel_id='" . $this->roomTypeHotelId() . "'");
            return $this->MDatabase->result;
        }

        function deleteHotelRoomType()
        {
            $status = $this->MDatabase->delete($this->table_name, "room_type_id='" . $this->roomTypeId() . "'");
            $status = $this->MDatabase->delete("room_rates", "hotel_room_type_id='" . $this->roomTypeId() . "'");
            $status = $this->MDatabase->delete("room_control", "rc_room_type_id='" . $this->roomTypeId() . "'");
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