<?php

    class administrator
    {

        private $id;
        private $name;
        private $username;
        private $password;
        private $email;

        private $table_name = "administrators";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function newAdministrator()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "name"     => $this->name(),
                "username" => $this->username(),
                "password" => md5($this->password()),
                "email"    => $this->email()
            ));

            return $status;

        }

        function name()
        {
            return $this->name;
        }

        function username()
        {
            return $this->username;
        }

        function password()
        {
            return $this->password;
        }

        //------------------------//

        function email()
        {
            return $this->email;
        }

        function updateAdministrator()
        {

            if ($this->password() != "") {

                $status = $this->MDatabase->update($this->table_name, array(
                    "name"     => $this->name(),
                    "username" => $this->username(),
                    "password" => md5($this->password()),
                    "email"    => $this->email()
                ), array("id" => $this->id()));

            } else {

                $status = $this->MDatabase->update($this->table_name, array(
                    "name"     => $this->name(),
                    "username" => $this->username(),
                    "email"    => $this->email()
                ), array("id" => $this->id()));

            }

            return $status;

        }

        function id()
        {
            return $this->id;
        }

        function getAllAdminsPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAllAdminsCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAdminFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "id='" . $this->id() . "'");
            return $this->MDatabase->result;
        }

        function getAdminFromUsername()
        {
            $this->MDatabase->select($this->table_name, "*", "username='" . $this->username() . "'");
            return $this->MDatabase->result;
        }

        function deleteAdministrator()
        {
            $status = $this->MDatabase->delete($this->table_name, "id='" . $this->id() . "'");
            return $status;
        }

        function getAdminEmails()
        {
            $status = $this->MDatabase->select($this->table_name, "*" . "");
            $res = $this->MDatabase->result;
            $emailAddress = '';
            for ($p = 0; $p < count($res); $p++) {
                $this->extractor($res, $p);

                $emailAddress = $emailAddress . "," . $this->email();
            }
            return $emailAddress;
        }

        function extractor($results, $row = 0)
        {

            $this->setId($results[$row]['id']);
            $this->setName($results[$row]['name']);
            $this->setUsername($results[$row]['username']);
            $this->setPassword($results[$row]['password']);
            $this->setEmail($results[$row]['email']);

        }

        function setId($id)
        {
            $this->id = $id;
        }

        function setName($name)
        {
            $this->name = $name;
        }

        function setUsername($username)
        {
            $this->username = $username;
        }

        function setPassword($password)
        {
            $this->password = $password;
        }

        function setEmail($email)
        {
            $this->email = $email;
        }

        function setValues($data)
        {

            foreach ($data as $k => $v) {
                $this->$k = $v;
            }

        }

    }

?>