<?php

    class Members
    {

        private $member_id;
        private $member_title;
        private $member_first_name;
        private $member_last_name;
        private $member_address;
        private $member_phone_fixed;
        private $member_phone_mobile;
        private $member_email;
        private $member_username;
        private $member_password;
        private $member_ip_address;
        private $member_registered_date;
        private $member_status;
        private $member_zip_code;
        private $member_country;
        private $member_passport_NIC;

        private $table_name = "members";
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

            $this->setMemberId($results[$row]['member_id']);
            $this->setMemberTitle($results[$row]['member_title']);
            $this->setMemberFirstName($results[$row]['member_first_name']);
            $this->setMemberLastName($results[$row]['member_last_name']);
            $this->setMemberAddress($results[$row]['member_address']);
            $this->setMemberPhoneFixed($results[$row]['member_phone_fixed']);
            $this->setMemberPhoneMobile($results[$row]['member_phone_mobile']);
            $this->setMemberEmail($results[$row]['member_email']);
            $this->setMemberUsername($results[$row]['member_username']);
            $this->setMemberPassword($results[$row]['member_password']);
            $this->setMemberIpAddress($results[$row]['member_ip_address']);
            $this->setMemberRegisteredDate($results[$row]['member_registered_date']);
            $this->setMemberStatus($results[$row]['member_status']);
            $this->setMemberZipCode($results[$row]['member_zip_code']);
            $this->setMemberCountry($results[$row]['member_country']);
            $this->setMemberPassportNic($results[$row]['member_Passport_NIC']);

        }

        function setMemberId($member_id)
        {
            $this->member_id = $member_id;
        }

        function setMemberTitle($member_title)
        {
            $this->member_title = $member_title;
        }

        function setMemberFirstName($member_first_name)
        {
            $this->member_first_name = $member_first_name;
        }

        function setMemberLastName($member_last_name)
        {
            $this->member_last_name = $member_last_name;
        }

        function setMemberAddress($member_address)
        {
            $this->member_address = $member_address;
        }

        function setMemberPhoneFixed($member_phone_fixed)
        {
            $this->member_phone_fixed = $member_phone_fixed;
        }

        function setMemberPhoneMobile($member_phone_mobile)
        {
            $this->member_phone_mobile = $member_phone_mobile;
        }

        function setMemberEmail($member_email)
        {
            $this->member_email = $member_email;
        }

        function setMemberUsername($member_username)
        {
            $this->member_username = $member_username;
        }

        function setMemberPassword($member_password)
        {
            $this->member_password = $member_password;
        }

        function setMemberIpAddress($member_ip_address)
        {
            $this->member_ip_address = $member_ip_address;
        }

        function setMemberRegisteredDate($member_registered_date)
        {
            $this->member_registered_date = $member_registered_date;
        }

        function setMemberStatus($member_status)
        {
            $this->member_status = $member_status;
        }

        function setMemberZipCode($member_zip_code)
        {
            $this->member_zip_code = $member_zip_code;
        }

        //------------------------//

        function setMemberCountry($member_country)
        {
            $this->member_country = $member_country;
        }

        function setMemberPassportNic($member_Passport_NIC)
        {
            $this->member_Passport_NIC = $member_passport_NIC;
        }

        function newMember()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "member_title"           => $this->memberTitle(),
                "member_first_name"      => $this->memberFirstName(),
                "member_last_name"       => $this->memberLastName(),
                "member_address"         => $this->memberAddress(),
                "member_phone_fixed"     => $this->memberPhoneFixed(),
                "member_phone_mobile"    => $this->memberPhoneMobile(),
                "member_email"           => $this->memberEmail(),
                "member_zip_code"     => $this->memberZipCode(),
                "member_country"      => $this->memberCountry(),
                "member_username"        => $this->memberUsername(),
                "member_password"        => $this->settings["password_encryption_type"]($this->memberPassword()),
                "member_Passport_NIC" => $this->memberPassportNic(),
                "member_ip_address"      => $this->memberIpAddress(),
                "member_registered_date" => $this->memberRegisteredDate(),
                "member_status"          => $this->memberStatus()
            ));
            //echo $this->MDatabase->sqlquery;
            return $this->MDatabase->insert_id();

        }

        function memberTitle()
        {
            return $this->member_title;
        }

        function memberFirstName()
        {
            return $this->member_first_name;
        }

        function memberLastName()
        {
            return $this->member_last_name;
        }

        function memberAddress()
        {
            return $this->member_address;
        }

        function memberPhoneFixed()
        {
            return $this->member_phone_fixed;
        }

        function memberPhoneMobile()
        {
            return $this->member_phone_mobile;
        }

        function memberEmail()
        {
            return $this->member_email;
        }

        function memberUsername()
        {
            return $this->member_username;
        }

        function memberPassword()
        {
            return $this->member_password;
        }

        function memberIpAddress()
        {
            return $this->member_ip_address;
        }

        function memberRegisteredDate()
        {
            return $this->member_registered_date;
        }

        function memberStatus()
        {
            return $this->member_status;
        }

        function updateMember()
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "member_title"        => $this->memberTitle(),
                "member_first_name"   => $this->memberFirstName(),
                "member_last_name"    => $this->memberLastName(),
                "member_address"      => $this->memberAddress(),
                "member_email"        => $this->memberEmail(),
                "member_username"     => $this->memberUsername(),
                "member_phone_fixed"  => $this->memberPhoneFixed(),
                "member_phone_mobile" => $this->memberPhoneMobile(),
                "member_zip_code"     => $this->memberZipCode(),
                "member_country"      => $this->memberCountry(),
                "member_Passport_NIC" => $this->memberPassportNic(),

            ), array("member_id" => $this->memberId()));

            return $status;

        }

        function memberZipCode()
        {
            return $this->member_zip_code;
        }

        function memberCountry()
        {
            return $this->member_country;
        }

        function memberPassportNic()
        {
            return $this->member_passport_NIC;
        }

        function memberId()
        {
            return $this->member_id;
        }

        function changeLogin()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "member_password" => $this->settings["password_encryption_type"]($this->memberPassword())
            ), array("member_id" => $this->memberId()));
            //echo $this->MDatabase->sqlquery; die();
            return $status;

        }

        function getAllMemberPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAllMemberCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "", "", $page);
            return $this->MDatabase->result;
        }

        function getMemberFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "member_id='" . $this->memberId() . "'");
            return $this->MDatabase->result;
        }

        function deleteMember()
        {
            $status = $this->MDatabase->delete($this->table_name, "member_id='" . $this->memberId() . "'");
            return $status;
        }

        function isEmailExsists()
        {
            $eml = '';

            $eml = $this->emailEqual();

            if ($eml != $this->memberEmail()) {
                $this->MDatabase->select($this->table_name, "COUNT(*)", "member_email='" . $this->memberEmail() . "'");
                $res = $this->MDatabase->result;
                if ($res[0]["COUNT(*)"] == 1) {
                    return "false";
                } else {
                    return "true";
                }
            } else {
                return "true";
            }
        }

        function emailEqual()
        {
            $this->MDatabase->select($this->table_name, "member_email", "member_id=" . $this->memberId() . "");
            $res2 = $this->MDatabase->result;
            if ($res2)
                return $eml = $res2[0]["member_email"];
            else
                return '';
        }

        function isUserNameExsists()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*)", "member_username='" . $this->memberUsername() . "'");
            $res = $this->MDatabase->result;
            if ($res[0]["COUNT(*)"] == 1) {
                return "false";
            } else {
                return "true";
            }

        }

        function isUserNameExsistsEdit()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*)", "member_username='" . $this->memberUsername() . "' AND member_id !='" . $this->memberId() . "'");
            $res = $this->MDatabase->result;
            if ($res[0]["COUNT(*)"] == 1) {
                return "false";
            } else {
                return "true";
            }

        }

        function getMemberByUsername()
        {
            $this->MDatabase->select($this->table_name, "*", "member_username='" . $this->memberUsername() . "'");
            //echo $this->MDatabase->sqlquery; die();
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