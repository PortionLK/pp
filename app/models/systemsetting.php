<?php

    class systemSetting
    {

        private $sy_setting_id;
        private $sy_setting_smtp_username;
        private $sy_setting_smtp_password;
        private $sy_setting_host;
        private $sy_setting_port;
        private $sy_setting_from_name;
        private $sy_setting_company_logo;
        private $sy_setting_company_name;
        private $sy_setting_company_address;
        private $sy_setting_company_email;
        private $sy_setting_admin_email;
        private $sy_setting_reservation_email;
        private $sy_setting_company_phon;
        private $sy_setting_company_url;
        private $sy_setting_document_name;



        private $MDatabase;
        private $tbl_name;
        private $setting_per_page = 5;

        function __construct()
        {
            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = $this->setting_per_page;
            $this->tbl_name = "system_setting";
        }

        function sySettingId()
        {
            return $this->sy_setting_id;
        }

        function extractor($results, $row = 0)
        {

            $this->setSySettingId($results[$row]['sy_setting_id']);
            $this->setSySettingSmtpUsername($results[$row]['sy_setting_smtp_username']);
            $this->setSySettingSmtpPassword($results[$row]['sy_setting_smtp_password']);
            $this->setSySettingHost($results[$row]['sy_setting_host']);
            $this->setSySettingPort($results[$row]['sy_setting_port']);
            $this->setSySettingFromName($results[$row]['sy_setting_from_name']);
            $this->setSySettingCompanyLogo($results[$row]['sy_setting_company_logo']);
            $this->setSySettingCompanyName($results[$row]['sy_setting_company_name']);
            $this->setSySettingCompanyAddress($results[$row]['sy_setting_company_address']);
            $this->setSySettingCompanyEmail($results[$row]['sy_setting_company_email']);
            $this->setSySettingAdminEmail($results[$row]['sy_setting_admin_email']);
            $this->setSySettingReservationEmail($results[$row]['sy_setting_reservation_email']);
            $this->setSySettingCompanyPhon($results[$row]['sy_setting_company_phon']);
            $this->setSySettingCompanyUrl($results[$row]['sy_setting_company_url']);
            $this->setSySettingDocumentName($results[$row]['sy_setting_document_name']);


        }

        function setSySettingId($sy_setting_id)
        {
            $this->sy_setting_id = $sy_setting_id;
        }

        function setSySettingSmtpUsername($sy_setting_smtp_username)
        {
            $this->sy_setting_smtp_username = $sy_setting_smtp_username;
        }

        function setSySettingSmtpPassword($sy_setting_smtp_password)
        {
            $this->sy_setting_smtp_password = $sy_setting_smtp_password;
        }

        function setSySettingHost($sy_setting_host)
        {
            $this->sy_setting_host = $sy_setting_host;
        }

        function setSySettingPort($sy_setting_port)
        {
            $this->sy_setting_port = $sy_setting_port;
        }

        function setSySettingFromName($sy_setting_from_name)
        {
            $this->sy_setting_from_name = $sy_setting_from_name;
        }

        function setSySettingCompanyLogo($sy_setting_company_logo)
        {
            $this->sy_setting_company_logo = $sy_setting_company_logo;
        }

        function setSySettingCompanyName($sy_setting_company_name)
        {
            $this->sy_setting_company_name = $sy_setting_company_name;
        }

        function setSySettingCompanyAddress($sy_setting_company_address)
        {
            $this->sy_setting_company_address = $sy_setting_company_address;
        }

        function setSySettingCompanyEmail($sy_setting_company_email)
        {
            $this->sy_setting_company_email = $sy_setting_company_email;
        }

        function setSySettingAdminEmail($sy_setting_admin_email)
        {
            $this->sy_setting_admin_email = $sy_setting_admin_email;
        }

        function setSySettingReservationEmail($sy_setting_reservation_email)
        {
            $this->sy_setting_reservation_email = $sy_setting_reservation_email;
        }

        //------------------------//

        function setSySettingCompanyPhon($sy_setting_company_phon)
        {
            $this->sy_setting_company_phon = $sy_setting_company_phon;
        }

        function setSySettingCompanyUrl($sy_setting_company_url)
        {
            $this->sy_setting_company_url = $sy_setting_company_url;
        }

        function setSySettingDocumentName($sy_setting_document_name)
        {
            $this->sy_setting_document_name = $sy_setting_document_name;
        }

        function editSetting()
        {
            return $this->MDatabase->update($this->tbl_name, array(
                "sy_setting_smtp_username"   => $this->sySettingSmtpUsername(),
                "sy_setting_smtp_password"   => $this->sySettingSmtpPassword(),
                "sy_setting_host"            => $this->sySettingHost(),
                "sy_setting_port"            => $this->sySettingPort(),
                "sy_setting_from_name"       => $this->sySettingFromName(),
                "sy_setting_company_logo"    => $this->sySettingCompanyLogo(),
                "sy_setting_company_name"    => $this->sySettingCompanyName(),
                "sy_setting_company_address" => $this->sySettingCompanyAddress(),
                "sy_setting_company_email"   => $this->sySettingCompanyEmail(),
                "sy_setting_admin_email"   => $this->sySettingAdminEmail(),
                "sy_setting_reservation_email"   => $this->sySettingReservationEmail(),
                "sy_setting_company_phon"    => $this->sySettingCompanyPhon(),
                "sy_setting_company_url"     => $this->sySettingCompanyUrl(),
                "sy_setting_document_name"   => $this->sySettingDocumentName()

            ), array("sy_setting_id" => 1));
        }

        function sySettingSmtpUsername()
        {
            return $this->sy_setting_smtp_username;
        }

        function sySettingSmtpPassword()
        {
            return $this->sy_setting_smtp_password;
        }

        function sySettingHost()
        {
            return $this->sy_setting_host;
        }

        function sySettingPort()
        {
            return $this->sy_setting_port;
        }

        function sySettingFromName()
        {
            return $this->sy_setting_from_name;
        }

        function sySettingCompanyLogo()
        {
            return $this->sy_setting_company_logo;
        }

        function sySettingCompanyName()
        {
            return $this->sy_setting_company_name;
        }

        function sySettingCompanyAddress()
        {
            return $this->sy_setting_company_address;
        }

        function sySettingCompanyEmail()
        {
            return $this->sy_setting_company_email;
        }

        function sySettingAdminEmail()
        {
            return $this->sy_setting_admin_email;
        }

        function sySettingReservationEmail()
        {
            return $this->sy_setting_reservation_email;
        }

        function sySettingCompanyPhon()
        {
            return $this->sy_setting_company_phon;
        }

        function sySettingCompanyUrl()
        {
            return $this->sy_setting_company_url;
        }

        function sySettingDocumentName()
        {
            return $this->sy_setting_document_name;
        }

        function getSettings()
        {
            $this->MDatabase->select($this->tbl_name, "*");
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