<?php

    class BookingClient
    {

        private $id;
        private $name;
        private $email;
        private $contactno;
        private $address1;
        private $address2;
        private $country;
        private $city;
        private $state;
        private $zipcode;
        private $message;
        private $paymenttype;
        private $table_name = "booking_client";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function extractor($results, $row = 0)
        {

            $this->setId($results[$row]['id']);
            $this->setName($results[$row]['name']);
            $this->setEmail($results[$row]['email']);
            $this->setContactno($results[$row]['contactno']);
            $this->setAddress1($results[$row]['address1']);
            $this->setAddress2($results[$row]['address2']);
            $this->setCountry($results[$row]['country']);
            $this->setCity($results[$row]['city']);
            $this->setState($results[$row]['state']);
            $this->setZipcode($results[$row]['zipcode']);
            $this->setMessage($results[$row]['message']);
            $this->setPaymenttype($results[$row]['paymenttype ']);

        }

        function setId($id)
        {
            $this->id = $id;
        }

        function setName($name)
        {
            $this->name = $name;
        }

        function setEmail($email)
        {
            $this->email = $email;
        }

        function setContactno($contactno)
        {
            $this->contactno = $contactno;
        }

        function setAddress1($address1)
        {
            $this->address1 = $address1;
        }

        function setAddress2($address2)
        {
            $this->address2 = $address2;
        }

        function setCountry($country)
        {
            $this->country = $country;
        }

        function setCity($city)
        {
            $this->city = $city;
        }

        function setState($state)
        {
            $this->state = $state;
        }

        function setZipcode($zipcode)
        {
            $this->zipcode = $zipcode;
        }

        //------------------------//

        function setMessage($message)
        {
            $this->message = $message;
        }

        function setPaymenttype($paymenttype)
        {
            $this->paymenttype = $paymenttype;
        }

        function addClients()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "name"        => $this->name(),
                "email"       => $this->email(),
                "contactno"   => $this->contactno(),
                "address1"    => $this->address1(),
                "address2"    => $this->address2(),
                "country"     => $this->country(),
                "city"        => $this->city(),
                "state"       => $this->state(),
                "zipcode"     => $this->zipcode(),
                "message"     => $this->message(),
                "paymenttype" => $this->paymenttype()

            ));

            return $status;

        }

        function name()
        {
            return $this->name;
        }

        function email()
        {
            return $this->email;
        }

        function contactno()
        {
            return $this->contactno;
        }

        function address1()
        {
            return $this->address1;
        }

        function address2()
        {
            return $this->address2;
        }

        function country()
        {
            return $this->country;
        }

        function city()
        {
            return $this->city;
        }

        function state()
        {
            return $this->state;
        }

        function zipcode()
        {
            return $this->zipcode;
        }

        function message()
        {
            return $this->message;
        }

        function paymenttype()
        {
            return $this->paymenttype;
        }

        function updateClients()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "name"        => $this->name(),
                "email"       => $this->email(),
                "contactno"   => $this->contactno(),
                "address1"    => $this->address1(),
                "address2"    => $this->address2(),
                "country"     => $this->country(),
                "city"        => $this->city(),
                "state"       => $this->state(),
                "zipcode"     => $this->zipcode(),
                "message"     => $this->message(),
                "paymenttype" => $this->paymenttype()
            ), array("id" => $this->id()));

            return $status;

        }

        function id()
        {
            return $this->id;
        }

        function getAllClientsPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAllClientsCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "", "", $page);
            return $this->MDatabase->result;
        }

        function getClientsFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "id='" . $this->id() . "'");
            return $this->MDatabase->result;
        }

        function getAllClients()
        {
            $this->MDatabase->select($this->table_name, "*", '', "id DESC");
            return $this->MDatabase->result;
        }

        function deleteClients()
        {
            $status = $this->MDatabase->delete($this->table_name, "id='" . $this->id() . "'");
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