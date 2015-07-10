<?php

    class HotelImages
    {

        private $image_id;
        private $image_hotel_id;
        private $image_type;
        private $image_name;
        private $image_title;
        private $image_position;

        private $table_name = "hotel_images";
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
            $this->setImageHotelId($results[$row]['image_hotel_id']);
            $this->setImageType($results[$row]['image_type']);
            $this->setImageName($results[$row]['image_name']);
            $this->setImageTitle($results[$row]['image_title']);
            $this->setImagePosition($results[$row]['image_position']);

        }

        function setImageId($image_id)
        {
            $this->image_id = $image_id;
        }

        function setImageHotelId($image_hotel_id)
        {
            $this->image_hotel_id = $image_hotel_id;
        }

        function setImageType($image_type)
        {
            $this->image_type = $image_type;
        }

        //------------------------//

        function setImageName($image_name)
        {
            $this->image_name = $image_name;
        }

        function setImageTitle($image_title)
        {
            $this->image_title = $image_title;
        }

        function setImagePosition($image_position)
        {
            $this->image_position = $image_position;
        }

        function newImage()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "image_hotel_id" => $this->imageHotelId(),
                "image_type"     => $this->imageType(),
                "image_name"     => $this->imageName(),
                "image_title"    => $this->imageTitle(),
                "image_position" => $this->imagePosition()
            ));

            return $status;

        }

        function updateImageTitle()
        {
            $status = $this->MDatabase->update($this->table_name, array("image_title" => $this->image_title), array("image_hotel_id" => $this->image_hotel_id, "image_id" => $this->image_id));
            return $status;
        }

        function imageHotelId()
        {
            return $this->image_hotel_id;
        }

        function imageType()
        {
            return $this->image_type;
        }

        function imageName()
        {
            return $this->image_name;
        }

        function imageTitle()
        {
            return $this->image_title;
        }

        function imagePosition()
        {
            return $this->image_position;
        }

        function updateCurrency()
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "curr_code"   => $this->currCode(),
                "curr_prefix" => $this->currPrefix(),
                "curr_suffix" => $this->currSuffix(),
                "curr_value"  => $this->currValue()
            ), array("curr_id" => $this->currId()));

            return $status;

        }

        function getImageFromHotelsIdOne()
        {
            $this->MDatabase->select($this->table_name, "*", "image_hotel_id='" . $this->imageHotelId() . "'", "image_position ASC limit 0,1");
            //echo $this->MDatabase->sqlquery; die();
            return $this->MDatabase->result;
        }

        function getImageFromHotelsId()
        {
            $this->MDatabase->select($this->table_name, "*", "image_hotel_id='" . $this->imageHotelId() . "'");
            return $this->MDatabase->result;
        }

        function getHotelImageById()
        {
            $img_list = array();
            $data = $this->getImageFromHotelsId();
            if(count($data)>0){
                foreach ($data as $image){
                    if(file_exists(DOC_ROOT . 'uploads/hotel-gal/' . $image['image_name'])){
                        $img_list[] = array("image_name" => $image['image_name'], "image_title" => $image['image_title']);
                    }
                }
            }
            return ($img_list);
        }

        function getImageDetailFromImage()
        {
            $this->MDatabase->select($this->table_name, "*", "image_name='" . $this->imageName() . "'");
            return $this->MDatabase->result;
        }

        function deleteCurrency()
        {
            $status = $this->MDatabase->delete($this->table_name, "curr_id='" . $this->currId() . "'");
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