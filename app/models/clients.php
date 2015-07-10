<?php

    class Clients
    {

        private $client_id;
        private $client_title;
        private $client_first_name;
        private $client_last_name;
        private $client_address;
        private $client_zip_code;
        private $client_country;
        private $client_nationality;
        private $client_city;
        private $client_phone_fixed;
        private $client_phone_mobile;
        private $client_phone_fax;
        private $client_email;
        private $client_username;
        private $client_password;
        private $client_passport;
        private $client_status;
        private $client_language;
        private $client_ip_address;
        private $client_registered_date;

        private $table_name = "clients";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;
            $this->settings = array(
                "password_encryption_type" => "md5",
            );

        }

        function extractor($results, $row = 0)
        {

            $this->setClientId($results[$row]['client_id']);
            $this->setClientTitle($results[$row]['client_title']);
            $this->setClientFirstName($results[$row]['client_first_name']);
            $this->setClientLastName($results[$row]['client_last_name']);
            $this->setClientAddress($results[$row]['client_address']);
            $this->setClientZipCode($results[$row]['client_zip_code']);
            $this->setClientCountry($results[$row]['client_country']);
            $this->setClientNationality($results[$row]['client_nationality']);
            $this->setClientCity($results[$row]['client_city']);
            $this->setClientPhoneFixed($results[$row]['client_phone_fixed']);
            $this->setClientPhoneMobile($results[$row]['client_phone_mobile']);
            $this->setClientPhoneFax($results[$row]['client_phone_fax']);
            $this->setClientEmail($results[$row]['client_email']);
            $this->setClientUsername($results[$row]['client_username']);
            $this->setClientPassword($results[$row]['client_password']);
            $this->setClientPassport($results[$row]['client_passport']);
            $this->setClientStatus($results[$row]['client_status']);
            $this->setClientLanguage($results[$row]['client_language']);
            $this->setClientIpAddress($results[$row]['client_ip_address']);
            $this->setClientRegisteredDate($results[$row]['client_registered_date']);

        }

        function setClientId($client_id)
        {
            $this->client_id = $client_id;
        }

        function setClientTitle($client_title)
        {
            $this->client_title = $client_title;
        }

        function setClientFirstName($client_first_name)
        {
            $this->client_first_name = $client_first_name;
        }

        function setClientLastName($client_last_name)
        {
            $this->client_last_name = $client_last_name;
        }

        function setClientAddress($client_address)
        {
            $this->client_address = $client_address;
        }

        function setClientZipCode($client_zip_code)
        {
            $this->client_zip_code = $client_zip_code;
        }

        function setClientCountry($client_country)
        {
            $this->client_country = $client_country;
        }

        function setClientNationality($client_nationality)
        {
            $this->client_nationality = $client_nationality;
        }

        function setClientCity($client_city)
        {
            $this->client_city = $client_city;
        }

        function setClientPhoneFixed($client_phone_fixed)
        {
            $this->client_phone_fixed = $client_phone_fixed;
        }

        function setClientPhoneMobile($client_phone_mobile)
        {
            $this->client_phone_mobile = $client_phone_mobile;
        }

        function setClientPhoneFax($client_phone_fax)
        {
            $this->client_phone_fax = $client_phone_fax;
        }

        function setClientEmail($client_email)
        {
            $this->client_email = $client_email;
        }

        function setClientUsername($client_username)
        {
            $this->client_username = $client_username;
        }

        function setClientPassword($client_password)
        {
            $this->client_password = $client_password;
        }

        function setClientPassport($client_passport)
        {
            $this->client_passport = $client_passport;
        }

        function setClientStatus($client_status)
        {
            $this->client_status = $client_status;
        }

        function setClientLanguage($client_language)
        {
            $this->client_language = $client_language;
        }

        //------------------------//

        function setClientIpAddress($client_ip_address)
        {
            $this->client_ip_address = $client_ip_address;
        }

        function setClientRegisteredDate($client_registered_date)
        {
            $this->client_registered_date = $client_registered_date;
        }

        function newClients()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "client_title"           => $this->clientTitle(),
                "client_first_name"      => $this->clientFirstName(),
                "client_last_name"       => $this->clientLastName(),
                "client_address"         => $this->clientAddress(),
                "client_zip_code"        => $this->clientZipCode(),
                "client_country"         => $this->clientCountry(),
                "client_nationality"     => $this->clientNationality(),
                "client_city"            => $this->clientCity(),
                "client_phone_fixed"     => $this->clientPhoneFixed(),
                "client_phone_mobile"    => $this->clientPhoneMobile(),
                "client_phone_fax"       => $this->clientPhoneFax(),
                "client_email"           => $this->clientEmail(),
                "client_username"        => $this->clientUsername(),
                "client_password"        => md5($this->clientPassword()),
                "client_passport"        => $this->clientPassport(),
                "client_status"          => $this->clientStatus(),
                "client_language"        => $this->clientLanguage(),
                "client_ip_address"      => $this->clientIpAddress(),
                "client_registered_date" => $this->clientRegisteredDate()
            ));

            return $this->MDatabase->insert_id();

        }

        function clientTitle()
        {
            return $this->client_title;
        }

        function clientFirstName()
        {
            return $this->client_first_name;
        }

        function clientLastName()
        {
            return $this->client_last_name;
        }

        function clientAddress()
        {
            return $this->client_address;
        }

        function clientZipCode()
        {
            return $this->client_zip_code;
        }

        function clientCountry()
        {
            return $this->client_country;
        }

        function clientNationality()
        {
            return $this->client_nationality;
        }

        function clientCity()
        {
            return $this->client_city;
        }

        function clientPhoneFixed()
        {
            return $this->client_phone_fixed;
        }

        function clientPhoneMobile()
        {
            return $this->client_phone_mobile;
        }

        function clientPhoneFax()
        {
            return $this->client_phone_fax;
        }

        function clientEmail()
        {
            return $this->client_email;
        }

        function clientUsername()
        {
            return $this->client_username;
        }

        function clientPassword()
        {
            return $this->client_password;
        }

        function clientPassport()
        {
            return $this->client_passport;
        }

        function clientStatus()
        {
            return $this->client_status;
        }

        function clientLanguage()
        {
            return $this->client_language;
        }

        function clientIpAddress()
        {
            return $this->client_ip_address;
        }

        function clientRegisteredDate()
        {
            return $this->client_registered_date;
        }

        function updateClient()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "client_title"        => $this->clientTitle(),
                "client_first_name"   => $this->clientFirstName(),
                "client_last_name"    => $this->clientLastName(),
                "client_address"      => $this->clientAddress(),
                "client_zip_code"     => $this->clientZipCode(),
                "client_country"      => $this->clientCountry(),
                "client_nationality"  => $this->clientNationality(),
                "client_city"         => $this->clientCity(),
                "client_phone_fixed"  => $this->clientPhoneFixed(),
                "client_phone_mobile" => $this->clientPhoneMobile(),
                "client_phone_fax"    => $this->clientPhoneFax(),
                "client_email"        => $this->clientEmail(),
                "client_username"     => $this->clientUsername(),
                "client_passport"     => $this->clientPassport(),
                "client_language"     => $this->clientLanguage(),
            ), array("client_id" => $this->clientId()));

            //echo $this->MDatabase->sqlquery; die();
            return $status;

        }

        function clientId()
        {
            return $this->client_id;
        }

        function changeLogin()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "client_password" => md5($this->clientPassword())
            ), array("client_id" => $this->clientId()));
            //echo $this->MDatabase->sqlquery; die();
            return $status;

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

        function getClientFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "client_id='" . $this->clientId() . "'");
            return $this->MDatabase->result;
        }

        function deleteClient()
        {
            $status = $this->MDatabase->delete($this->table_name, "client_id='" . $this->clientId() . "'");
            return $status;
        }

        function isEmailExsists()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*)", "client_email='" . $this->clientEmail() . "'");
            $res = $this->MDatabase->result;
            if ($res[0]["COUNT(*)"] == 1) {
                return "false";
            } else {
                return "true";
            }

        }

        function isUserNameExsists()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*)", "client_username='" . $this->clientUsername() . "'");
            $res = $this->MDatabase->result;
            if ($res[0]["COUNT(*)"] == 1) {
                return "false";
            } else {
                return "true";
            }

        }

        function isUserNameExsistsEdit()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*)", "client_username='" . $this->clientUsername() . "' AND client_id !='" . $this->clientId() . "'");
            $res = $this->MDatabase->result;
            if ($res[0]["COUNT(*)"] == 1) {
                return "false";
            } else {
                return "true";
            }

        }


        //---------password exsis function----------//

        // function isUserNameExsistsEdit(){
        // $this->MDatabase->select($this->table_name,"COUNT(*)","client_username='".$this->clientUsername()."' AND client_id !='".$this->clientId()."'" );
        // $res = $this->MDatabase->result;
        // if($res[0]["COUNT(*)"] == 1){
        // return "false";
        // }else{
        // return "true";
        // }
// 
        // }

        function getClientFromUsername()
        {
            $this->MDatabase->select($this->table_name, "*", "client_username='" . $this->clientUsername() . "'");
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