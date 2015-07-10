<?php

    class ProfileCompletion
    {

        private $hotel_step_id;
        private $hotel_step_hotels_id;
        private $hotel_step1;
        private $hotel_step2;
        private $hotel_step3;
        private $hotel_step4;
        private $hotel_step5;
        private $hotel_step6;
        private $hotel_step7;
        private $hotel_step8;
        private $hotel_step9; //INFO: Special Offers
        private $profile_completion;

        private $table_name = "profile_completion";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function extractor($results, $row = 0)
        {

            $this->setHotelStepId($results[$row]['hotel_step_id']);
            $this->setHotelStepHotelsId($results[$row]['hotel_step_hotels_id']);
            $this->setHotelStep1($results[$row]['hotel_step1']);
            $this->setHotelStep2($results[$row]['hotel_step2']);
            $this->setHotelStep3($results[$row]['hotel_step3']);
            $this->setHotelStep4($results[$row]['hotel_step4']);
            $this->setHotelStep5($results[$row]['hotel_step5']);
            $this->setHotelStep6($results[$row]['hotel_step6']);
            $this->setHotelStep7($results[$row]['hotel_step7']);
            $this->setHotelStep8($results[$row]['hotel_step8']);
            $this->setHotelStep9($results[$row]['hotel_step9']); //INFO: Special Offers
            $this->setProfileCompletion($results[$row]['profile_completion']);

        }

        function setHotelStepId($hotel_step_id)
        {
            $this->hotel_step_id = $hotel_step_id;
        }

        function setHotelStep1($hotel_step1)
        {
            $this->hotel_step1 = $hotel_step1;
        }

        function setHotelStep2($hotel_step2)
        {
            $this->hotel_step2 = $hotel_step2;
        }

        function setHotelStep3($hotel_step3)
        {
            $this->hotel_step3 = $hotel_step3;
        }

        function setHotelStep4($hotel_step4)
        {
            $this->hotel_step4 = $hotel_step4;
        }

        function setHotelStep5($hotel_step5)
        {
            $this->hotel_step5 = $hotel_step5;
        }

        function setHotelStep6($hotel_step6)
        {
            $this->hotel_step6 = $hotel_step6;
        }

        function setHotelStep7($hotel_step7)
        {
            $this->hotel_step7 = $hotel_step7;
        }

        function setHotelStep8($hotel_step8)
        {
            $this->hotel_step8 = $hotel_step8;
        }

        function setHotelStep9($hotel_step9)
        {
            $this->hotel_step9 = $hotel_step9;
        }

//INFO: Special Offers

        function setProfileCompletion($profile_completion)
        {
            $this->profile_completion = $profile_completion;
        }

        function newProfileCompletion()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "hotel_step_hotels_id" => $this->hotelStepHotelsId(),
                "hotel_step1"          => $this->hotelStep1(),
                "hotel_step2"          => $this->hotelStep2(),
                "hotel_step3"          => $this->hotelStep3(),
                "hotel_step4"          => $this->hotelStep4(),
                "hotel_step5"          => $this->hotelStep5(),
                "hotel_step6"          => $this->hotelStep6(),
                "hotel_step7"          => $this->hotelStep7(),
                "hotel_step8"          => $this->hotelStep8(),
                "hotel_step9"          => $this->hotelStep9(), //INFO: Special Offers
                "profile_completion"   => $this->profileCompletion()
            ));

            return $status;

        }

        function hotelStepHotelsId()
        {
            return $this->hotel_step_hotels_id;
        }

        function hotelStep1()
        {
            return $this->hotel_step1;
        }

        function hotelStep2()
        {
            return $this->hotel_step2;
        }

        function hotelStep3()
        {
            return $this->hotel_step3;
        }

        function hotelStep4()
        {
            return $this->hotel_step4;
        }

        function hotelStep5()
        {
            return $this->hotel_step5;
        }

        function hotelStep6()
        {
            return $this->hotel_step6;
        }

        function hotelStep7()
        {
            return $this->hotel_step7;
        }

//INFO: Special Offers

        function hotelStep8()
        {
            return $this->hotel_step8;
        }

        function hotelStep9()
        {
            return $this->hotel_step9;
        }

        function profileCompletion()
        {
            return $this->profile_completion;
        }

        function updateProfileCompletion()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "hotel_step_hotels_id" => $this->hotelStepHotelsId(),
                "hotel_step1"          => $this->hotelStep1(),
                "hotel_step2"          => $this->hotelStep2(),
                "hotel_step3"          => $this->hotelStep3(),
                "hotel_step4"          => $this->hotelStep4(),
                "hotel_step5"          => $this->hotelStep5(),
                "hotel_step6"          => $this->hotelStep6(),
                "hotel_step7"          => $this->hotelStep7(),
                "hotel_step8"          => $this->hotelStep8(),
                "hotel_step9"          => $this->hotelStep9(), //INFO: Special Offers
                "profile_completion"   => $this->profileCompletion()
            ), array("hotel_step_id" => $this->hotelStepId()));

            return $status;

        }

        function hotelStepId()
        {
            return $this->hotel_step_id;
        }

        function updateProfileCompletionStep($step)
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "hotel_step" . $step => $this->hotelStep1(),
            ), array("hotel_step_id" => $this->hotelStepId()));
            return $status;
        }

        function updateProfileCompletionStepByHotel($step)
        {
            $status = $this->MDatabase->update($this->table_name, array("hotel_step" . $step => $this->hotelStep1()), array("hotel_step_hotels_id" => $this->getHotelStepHotelsId()));
            return $status;
        }

        function getHotelStepHotelsId()
        {
            return $this->hotel_step_hotels_id;
        }

        function setHotelStepHotelsId($hotel_step_hotels_id)
        {
            $this->hotel_step_hotels_id = $hotel_step_hotels_id;
        }

        function getAllProfileCompletionPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAllProfileCompletionCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "", "", $page);
            return $this->MDatabase->result;
        }

        function getProfileCompletionFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_step_id='" . $this->hotelStepId() . "'");
            return $this->MDatabase->result;
        }

        function getProfileCompletionFromHotelId()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_step_hotels_id='" . $this->hotelStepHotelsId() . "'");
            return $this->MDatabase->result;
        }

        function deleteProfileCompletion()
        {
            $status = $this->MDatabase->delete($this->table_name, "hotel_step_id='" . $this->hotelStepId() . "'");
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