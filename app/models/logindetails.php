<?php

    class LoginDetails
    {

        private $U_ID;
        private $U_L_ID;
        private $U_L_IP;
        private $U_L_INTIME;

        private $table_name = "logindetails";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function extractor($results, $row = 0)
        {

            $this->setUId($results[$row]['U_ID']);
            $this->setULId($results[$row]['U_L_ID']);
            $this->setULIp($results[$row]['U_L_IP']);
            $this->setULIntime($results[$row]['U_L_INTIME']);

        }

        function setUId($U_ID)
        {
            $this->U_ID = $U_ID;
        }

        function setULId($U_L_ID)
        {
            $this->U_L_ID = $U_L_ID;
        }

        //------------------------//

        function setULIp($U_L_IP)
        {
            $this->U_L_IP = $U_L_IP;
        }

        function setULIntime($U_L_INTIME)
        {
            $this->U_L_INTIME = $U_L_INTIME;
        }

        function newLoginDetails()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "U_L_ID"     => $this->uLId(),
                "U_L_IP"     => $this->uLIp(),
                "U_L_INTIME" => $this->uLIntime()
            ));

            return $status;

        }

        function uLId()
        {
            return $this->U_L_ID;
        }

        function uLIp()
        {
            return $this->U_L_IP;
        }

        function uLIntime()
        {
            return $this->U_L_INTIME;
        }

        function updateLoginDetails()
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "U_L_ID"     => $this->uLId(),
                "U_L_IP"     => $this->uLIp(),
                "U_L_INTIME" => $this->uLIntime()
            ), array("U_ID" => $this->uId()));

            return $status;

        }

        function uId()
        {
            return $this->U_ID;
        }

        function getAllLoginDetailsPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAllLoginDetailsCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "", "", $page);
            return $this->MDatabase->result;
        }

        function getLoginDetailsFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "U_ID='" . $this->uId() . "'");
            return $this->MDatabase->result;
        }

        function deleteLoginDetails()
        {
            $status = $this->MDatabase->delete($this->table_name, "U_ID='" . $this->uId() . "'");
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