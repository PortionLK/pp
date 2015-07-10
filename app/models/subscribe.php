<?php

    class Subscribe
    {

        private $id;
        private $email;

        private $table_name = "subscribe";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function id()
        {
            return $this->id;
        }

        //------------------------//

        function extractor($results, $row = 0)
        {

            $this->setId($results[$row]['id']);
            $this->setEmail($results[$row]['email']);

        }

        function setId($id)
        {
            $this->id = $id;
        }

        function setEmail($email)
        {
            $this->email = $email;
        }

        function newSubscribe()
        {

            $email = $this->email();

            $sql = "INSERT INTO `subscribe` (`email`) VALUES ('" . $email . "') ON DUPLICATE KEY UPDATE `email` = '" . $email . "'";
            $status = $this->MDatabase->custom($sql);

            return $status;

        }

        function email()
        {
            return $this->email;
        }

        function getAllSubscribePaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*", "", "id DESC", $page);
            return $this->MDatabase->result;
        }

        function getAllSubscribeCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "", "", $page);
            return $this->MDatabase->result;
        }

        function deleteSubscribe()
        {

            $status = $this->MDatabase->delete($this->table_name, "id='" . $this->id . "'");
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