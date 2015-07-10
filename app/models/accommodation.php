<?php

    class Accommodation
    {

        private $accommodation_id;
        private $accommodation_name;

        private $table_name = "accommodation";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function extractor($results, $row = 0)
        {

            $this->setAccommodationId($results[$row]['accommodation_id']);
            $this->setAccommodationName($results[$row]['accommodation_name']);

        }

        //------------------------//

        function setAccommodationId($accommodation_id)
        {
            $this->accommodation_id = $accommodation_id;
        }

        function setAccommodationName($accommodation_name)
        {
            $this->accommodation_name = $accommodation_name;
        }

        function newAccommodation()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "accommodation_name" => $this->accommodationName()
            ));

            return $status;

        }

        function accommodationName()
        {
            return $this->accommodation_name;
        }

        function updateAccommodation()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "accommodation_name" => $this->accommodationName()
            ), array("accommodation_id" => $this->accommodationId()));

            return $status;

        }

        function accommodationId()
        {
            return $this->accommodation_id;
        }

        function getAllAccommodationPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAllAccommodationCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAccommodationFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "accommodation_id='" . $this->accommodationId() . "'");
            return $this->MDatabase->result;
        }

        function getAllAccommodation()
        {
            $this->MDatabase->select($this->table_name, "*", '', "accommodation_id DESC");
            return $this->MDatabase->result;
        }

        function deleteAccommodation()
        {
            $status = $this->MDatabase->delete($this->table_name, "accommodation_id='" . $this->accommodationId() . "'");
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