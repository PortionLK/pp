<?php

    class HotelRoomTypeImages
    {

        private $image_id;
        private $image_room_type_id;
        private $image_name;

        private $table_name = "hotel_room_types_images";
        private $MDatabase;

        function __construct()
        {
            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);
            $this->MDatabase->rowsPerPage = 10;
        }

        function imageId()
        {
            return $this->image_id;
        }

        function extractor($results, $row = 0)
        {

            $this->setImageId($results[$row]['image_id']);
            $this->setImageRoomTypeId($results[$row]['image_room_type_id']);
            $this->setImageName($results[$row]['image_name']);
        }

        function setImageId($image_id)
        {
            $this->image_id = $image_id;
        }

        function setImageRoomTypeId($image_room_type_id)
        {
            $this->image_room_type_id = $image_room_type_id;
        }

        function setImageName($image_name)
        {
            $this->image_name = $image_name;
        }

        function newImage()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "image_room_type_id"     => $this->imageRoomTypeId(),
                "image_name" => $this->imageName()
            ));

            return $status;

        }

        function imageRoomTypeId()
        {
            return $this->image_room_type_id;
        }

        function imageName()
        {
            return $this->image_name;
        }

        function getImageFromRoomTypeId()
        {
            $this->MDatabase->select($this->table_name, "*", "image_room_type_id='" . $this->imageRoomTypeId() . "'");
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