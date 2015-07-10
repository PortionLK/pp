<?php

    class HotelRoomRates
    {

        private $room_rate_id;
        private $hotel_id;
        private $hotel_room_type_id;
        private $period_name;
        private $date_in;
        private $date_out;
        private $sgl_ro_fit_local;
        private $sgl_ro_sell_local;
        private $sgl_ro_fit_foriegn;
        private $sgl_ro_sell_foriegn;
        private $dbl_ro_fit_local;
        private $dbl_ro_sell_local;
        private $dbl_ro_fit_foriegn;
        private $dbl_ro_sell_foriegn;
        private $tpl_ro_fit_local;
        private $tpl_ro_sell_local;
        private $tpl_ro_fit_foriegn;
        private $tpl_ro_sell_foriegn;
        private $sgl_bb_fit_local;
        private $sgl_bb_sell_local;
        private $sgl_bb_fit_foriegn;
        private $sgl_bb_sell_foriegn;
        private $dbl_bb_fit_local;
        private $dbl_bb_sell_local;
        private $dbl_bb_fit_foriegn;
        private $dbl_bb_sell_foriegn;
        private $tpl_bb_fit_local;
        private $tpl_bb_sell_local;
        private $tpl_bb_fit_foriegn;
        private $tpl_bb_sell_foriegn;
        private $sgl_hb_fit_local;
        private $sgl_hb_sell_local;
        private $sgl_hb_fit_foriegn;
        private $sgl_hb_sell_foriegn;
        private $dbl_hb_fit_local;
        private $dbl_hb_sell_local;
        private $dbl_hb_fit_foriegn;
        private $dbl_hb_sell_foriegn;
        private $tpl_hb_fit_local;
        private $tpl_hb_sell_local;
        private $tpl_hb_fit_foriegn;
        private $tpl_hb_sell_foriegn;
        private $sgl_fb_fit_local;
        private $sgl_fb_sell_local;
        private $sgl_fb_fit_foriegn;
        private $sgl_fb_sell_foriegn;
        private $dbl_fb_fit_local;
        private $dbl_fb_sell_local;
        private $dbl_fb_fit_foriegn;
        private $dbl_fb_sell_foriegn;
        private $tpl_fb_fit_local;
        private $tpl_fb_sell_local;
        private $tpl_fb_fit_foriegn;
        private $tpl_fb_sell_foriegn;
        private $sgl_ai_fit_local;
        private $sgl_ai_sell_local;
        private $sgl_ai_fit_foriegn;
        private $sgl_ai_sell_foriegn;
        private $dbl_ai_fit_local;
        private $dbl_ai_sell_local;
        private $dbl_ai_fit_foriegn;
        private $dbl_ai_sell_foriegn;
        private $tpl_ai_fit_local;
        private $tpl_ai_sell_local;
        private $tpl_ai_fit_foriegn;
        private $tpl_ai_sell_foriegn;
        private $discount_rates_up_foriegn;
        private $discount_rates_up_local;
        private $hotel_price_min_local;
        private $hotel_price_min_foriegn;
        private $modified_date;

//TODO:Common rate
        private $rate;

        private $table_name = "room_rates";
        private $MDatabase;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function rate()
        {
            return $this->rate;
        }

        function setRate($rate)
        {
            $this->rate = $rate;
        }

        /**
         * @param string $fieldSet 'All','Local','Foreign'
         * @return array
         */
        //INFO: All Inclusive cols removed as they are not included in Add/Edit rates form.
        function getRateFields($fieldSet='All'){
            $arr=array();
            if($fieldSet=='All'){
                $arr=array("sgl_ro_fit_local","sgl_ro_sell_local","sgl_ro_fit_foriegn","sgl_ro_sell_foriegn","dbl_ro_fit_local","dbl_ro_sell_local","dbl_ro_fit_foriegn","dbl_ro_sell_foriegn","tpl_ro_fit_local","tpl_ro_sell_local","tpl_ro_fit_foriegn","tpl_ro_sell_foriegn","sgl_bb_fit_local","sgl_bb_sell_local","sgl_bb_fit_foriegn","sgl_bb_sell_foriegn","dbl_bb_fit_local","dbl_bb_sell_local","dbl_bb_fit_foriegn","dbl_bb_sell_foriegn","tpl_bb_fit_local","tpl_bb_sell_local","tpl_bb_fit_foriegn","tpl_bb_sell_foriegn","sgl_hb_fit_local","sgl_hb_sell_local","sgl_hb_fit_foriegn","sgl_hb_sell_foriegn","dbl_hb_fit_local","dbl_hb_sell_local","dbl_hb_fit_foriegn","dbl_hb_sell_foriegn","tpl_hb_fit_local","tpl_hb_sell_local","tpl_hb_fit_foriegn","tpl_hb_sell_foriegn","sgl_fb_fit_local","sgl_fb_sell_local","sgl_fb_fit_foriegn","sgl_fb_sell_foriegn","dbl_fb_fit_local","dbl_fb_sell_local","dbl_fb_fit_foriegn","dbl_fb_sell_foriegn","tpl_fb_fit_local","tpl_fb_sell_local","tpl_fb_fit_foriegn","tpl_fb_sell_foriegn"); //,"sgl_ai_fit_local","sgl_ai_sell_local","sgl_ai_fit_foriegn","sgl_ai_sell_foriegn","dbl_ai_fit_local","dbl_ai_sell_local","dbl_ai_fit_foriegn","dbl_ai_sell_foriegn","tpl_ai_fit_local","tpl_ai_sell_local","tpl_ai_fit_foriegn","tpl_ai_sell_foriegn"
            }else if($fieldSet=='Local'){
                $arr=array("sgl_ro_fit_local","sgl_ro_sell_local","dbl_ro_fit_local","dbl_ro_sell_local","tpl_ro_fit_local","tpl_ro_sell_local","sgl_bb_fit_local","sgl_bb_sell_local","dbl_bb_fit_local","dbl_bb_sell_local","tpl_bb_fit_local","tpl_bb_sell_local","sgl_hb_fit_local","sgl_hb_sell_local","dbl_hb_fit_local","dbl_hb_sell_local","tpl_hb_fit_local","tpl_hb_sell_local","sgl_fb_fit_local","sgl_fb_sell_local","dbl_fb_fit_local","dbl_fb_sell_local","tpl_fb_fit_local","tpl_fb_sell_local");//,"sgl_ai_fit_local","sgl_ai_sell_local","dbl_ai_fit_local","dbl_ai_sell_local","tpl_ai_fit_local","tpl_ai_sell_local"
            }else if($fieldSet=='Foreign'){
                $arr=array("sgl_ro_fit_foriegn","sgl_ro_sell_foriegn","dbl_ro_fit_foriegn","dbl_ro_sell_foriegn","tpl_ro_fit_foriegn","tpl_ro_sell_foriegn","sgl_bb_fit_foriegn","sgl_bb_sell_foriegn","dbl_bb_fit_foriegn","dbl_bb_sell_foriegn","tpl_bb_fit_foriegn","tpl_bb_sell_foriegn","sgl_hb_fit_foriegn","sgl_hb_sell_foriegn","dbl_hb_fit_foriegn","dbl_hb_sell_foriegn","tpl_hb_fit_foriegn","tpl_hb_sell_foriegn","sgl_fb_fit_foriegn","sgl_fb_sell_foriegn","dbl_fb_fit_foriegn","dbl_fb_sell_foriegn","tpl_fb_fit_foriegn","tpl_fb_sell_foriegn");//,"sgl_ai_fit_foriegn","sgl_ai_sell_foriegn","dbl_ai_fit_foriegn","dbl_ai_sell_foriegn","tpl_ai_fit_foriegn","tpl_ai_sell_foriegn"
            }
            return $arr;
        }

        function extractor($results, $row = 0)
        {

            $this->setRoomRateId($results[$row]['room_rate_id']);
            $this->setHotelId($results[$row]['hotel_id']);
            $this->setHotelRoomTypeId($results[$row]['hotel_room_type_id']);
            $this->setPeriodName($results[$row]['period_name']);
            $this->setDateIn($results[$row]['date_in']);
            $this->setDateOut($results[$row]['date_out']);
            $this->setSglRoFitLocal($results[$row]['sgl_ro_fit_local']);
            $this->setSglRoSellLocal($results[$row]['sgl_ro_sell_local']);
            $this->setSglRoFitForiegn($results[$row]['sgl_ro_fit_foriegn']);
            $this->setSglRoSellForiegn($results[$row]['sgl_ro_sell_foriegn']);
            $this->setDblRoFitLocal($results[$row]['dbl_ro_fit_local']);
            $this->setDblRoSellLocal($results[$row]['dbl_ro_sell_local']);
            $this->setDblRoFitForiegn($results[$row]['dbl_ro_fit_foriegn']);
            $this->setDblRoSellForiegn($results[$row]['dbl_ro_sell_foriegn']);
            $this->setTplRoFitLocal($results[$row]['tpl_ro_fit_local']);
            $this->setTplRoSellLocal($results[$row]['tpl_ro_sell_local']);
            $this->setTplRoFitForiegn($results[$row]['tpl_ro_fit_foriegn']);
            $this->setTplRoSellForiegn($results[$row]['tpl_ro_sell_foriegn']);
            $this->setSglBbFitLocal($results[$row]['sgl_bb_fit_local']);
            $this->setSglBbSellLocal($results[$row]['sgl_bb_sell_local']);
            $this->setSglBbFitForiegn($results[$row]['sgl_bb_fit_foriegn']);
            $this->setSglBbSellForiegn($results[$row]['sgl_bb_sell_foriegn']);
            $this->setDblBbFitLocal($results[$row]['dbl_bb_fit_local']);
            $this->setDblBbSellLocal($results[$row]['dbl_bb_sell_local']);
            $this->setDblBbFitForiegn($results[$row]['dbl_bb_fit_foriegn']);
            $this->setDblBbSellForiegn($results[$row]['dbl_bb_sell_foriegn']);
            $this->setTplBbFitLocal($results[$row]['tpl_bb_fit_local']);
            $this->setTplBbSellLocal($results[$row]['tpl_bb_sell_local']);
            $this->setTplBbFitForiegn($results[$row]['tpl_bb_fit_foriegn']);
            $this->setTplBbSellForiegn($results[$row]['tpl_bb_sell_foriegn']);
            $this->setSglHbFitLocal($results[$row]['sgl_hb_fit_local']);

            $this->setSglHbSellLocal($results[$row]['sgl_hb_sell_local']);

            $this->setSglHbFitForiegn($results[$row]['sgl_hb_fit_foriegn']);

            $this->setSglHbSellForiegn($results[$row]['sgl_hb_sell_foriegn']);

            $this->setDblHbFitLocal($results[$row]['dbl_hb_fit_local']);

            $this->setDblHbSellLocal($results[$row]['dbl_hb_sell_local']);

            $this->setDblHbFitForiegn($results[$row]['dbl_hb_fit_foriegn']);

            $this->setDblHbSellForiegn($results[$row]['dbl_hb_sell_foriegn']);

            $this->setTplHbFitLocal($results[$row]['tpl_hb_fit_local']);

            $this->setTplHbSellLocal($results[$row]['tpl_hb_sell_local']);

            $this->setTplHbFitForiegn($results[$row]['tpl_hb_fit_foriegn']);

            $this->setTplHbSellForiegn($results[$row]['tpl_hb_sell_foriegn']);

            $this->setSglFbFitLocal($results[$row]['sgl_fb_fit_local']);

            $this->setSglFbSellLocal($results[$row]['sgl_fb_sell_local']);

            $this->setSglFbFitForiegn($results[$row]['sgl_fb_fit_foriegn']);

            $this->setSglFbSellForiegn($results[$row]['sgl_fb_sell_foriegn']);

            $this->setDblFbFitLocal($results[$row]['dbl_fb_fit_local']);

            $this->setDblFbSellLocal($results[$row]['dbl_fb_sell_local']);

            $this->setDblFbFitForiegn($results[$row]['dbl_fb_fit_foriegn']);

            $this->setDblFbSellForiegn($results[$row]['dbl_fb_sell_foriegn']);

            $this->setTplFbFitLocal($results[$row]['tpl_fb_fit_local']);

            $this->setTplFbSellLocal($results[$row]['tpl_fb_sell_local']);

            $this->setTplFbFitForiegn($results[$row]['tpl_fb_fit_foriegn']);

            $this->setTplFbSellForiegn($results[$row]['tpl_fb_sell_foriegn']);

            $this->setSglAiFitLocal($results[$row]['sgl_ai_fit_local']);

            $this->setSglAiSellLocal($results[$row]['sgl_ai_sell_local']);

            $this->setSglAiFitForiegn($results[$row]['sgl_ai_fit_foriegn']);

            $this->setSglAiSellForiegn($results[$row]['sgl_ai_sell_foriegn']);

            $this->setDblAiFitLocal($results[$row]['dbl_ai_fit_local']);

            $this->setDblAiSellLocal($results[$row]['dbl_ai_sell_local']);

            $this->setDblAiFitForiegn($results[$row]['dbl_ai_fit_foriegn']);

            $this->setDblAiSellForiegn($results[$row]['dbl_ai_sell_foriegn']);

            $this->setTplAiFitLocal($results[$row]['tpl_ai_fit_local']);

            $this->setTplAiSellLocal($results[$row]['tpl_ai_sell_local']);

            $this->setTplAiFitForiegn($results[$row]['tpl_ai_fit_foriegn']);

            $this->setTplAiSellForiegn($results[$row]['tpl_ai_sell_foriegn']);

            $this->setDiscountRatesUpForiegn($results[$row]['discount_rates_up_foriegn']);
            $this->setDiscountRatesUpLocal($results[$row]['discount_rates_up_local']);
            $this->setHotelPriceMinLocal($results[$row]['hotel_price_min_local']);
            $this->setHotelPriceMinForiegn($results[$row]['hotel_price_min_foriegn']);
            $this->setModifiedDate($results[$row]['modified_date']);

        }

        function setRoomRateId($room_rate_id)
        {
            $this->room_rate_id = $room_rate_id;
        }

        function setHotelId($hotel_id)
        {
            $this->hotel_id = $hotel_id;
        }

        function setHotelRoomTypeId($hotel_room_type_id)
        {
            $this->hotel_room_type_id = $hotel_room_type_id;
        }

        function setPeriodName($period_name)
        {
            $this->period_name = $period_name;
        }

        function setDateIn($date_in)
        {
            $this->date_in = $date_in;
        }

        function setDateOut($date_out)
        {
            $this->date_out = $date_out;
        }

        function setSglRoFitLocal($sgl_ro_fit_local)
        {
            $this->sgl_ro_fit_local = $sgl_ro_fit_local;
        }

        function setSglRoSellLocal($sgl_ro_sell_local)
        {
            $this->sgl_ro_sell_local = $sgl_ro_sell_local;
        }

        function setSglRoFitForiegn($sgl_ro_fit_foriegn)
        {
            $this->sgl_ro_fit_foriegn = $sgl_ro_fit_foriegn;
        }

        function setSglRoSellForiegn($sgl_ro_sell_foriegn)
        {
            $this->sgl_ro_sell_foriegn = $sgl_ro_sell_foriegn;
        }

        function setDblRoFitLocal($dbl_ro_fit_local)
        {
            $this->dbl_ro_fit_local = $dbl_ro_fit_local;
        }

        function setDblRoSellLocal($dbl_ro_sell_local)
        {
            $this->dbl_ro_sell_local = $dbl_ro_sell_local;
        }

        function setDblRoFitForiegn($dbl_ro_fit_foriegn)
        {
            $this->dbl_ro_fit_foriegn = $dbl_ro_fit_foriegn;
        }

        function setDblRoSellForiegn($dbl_ro_sell_foriegn)
        {
            $this->dbl_ro_sell_foriegn = $dbl_ro_sell_foriegn;
        }

        function setTplRoFitLocal($tpl_ro_fit_local)
        {
            $this->tpl_ro_fit_local = $tpl_ro_fit_local;
        }

        function setTplRoSellLocal($tpl_ro_sell_local)
        {
            $this->tpl_ro_sell_local = $tpl_ro_sell_local;
        }

        function setTplRoFitForiegn($tpl_ro_fit_foriegn)
        {
            $this->tpl_ro_fit_foriegn = $tpl_ro_fit_foriegn;
        }

        function setTplRoSellForiegn($tpl_ro_sell_foriegn)
        {
            $this->tpl_ro_sell_foriegn = $tpl_ro_sell_foriegn;
        }

        function setSglBbFitLocal($sgl_bb_fit_local)
        {
            $this->sgl_bb_fit_local = $sgl_bb_fit_local;
        }

        function setSglBbSellLocal($sgl_bb_sell_local)
        {
            $this->sgl_bb_sell_local = $sgl_bb_sell_local;
        }

        function setSglBbFitForiegn($sgl_bb_fit_foriegn)
        {
            $this->sgl_bb_fit_foriegn = $sgl_bb_fit_foriegn;
        }

        function setSglBbSellForiegn($sgl_bb_sell_foriegn)
        {
            $this->sgl_bb_sell_foriegn = $sgl_bb_sell_foriegn;
        }

        function setDblBbFitLocal($dbl_bb_fit_local)
        {
            $this->dbl_bb_fit_local = $dbl_bb_fit_local;
        }

        function setDblBbSellLocal($dbl_bb_sell_local)
        {
            $this->dbl_bb_sell_local = $dbl_bb_sell_local;
        }

        function setDblBbFitForiegn($dbl_bb_fit_foriegn)
        {
            $this->dbl_bb_fit_foriegn = $dbl_bb_fit_foriegn;
        }

        function setDblBbSellForiegn($dbl_bb_sell_foriegn)
        {
            $this->dbl_bb_sell_foriegn = $dbl_bb_sell_foriegn;
        }

        function setTplBbFitLocal($tpl_bb_fit_local)
        {
            $this->tpl_bb_fit_local = $tpl_bb_fit_local;
        }

        function setTplBbSellLocal($tpl_bb_sell_local)
        {
            $this->tpl_bb_sell_local = $tpl_bb_sell_local;
        }

        function setTplBbFitForiegn($tpl_bb_fit_foriegn)
        {
            $this->tpl_bb_fit_foriegn = $tpl_bb_fit_foriegn;
        }

        function setTplBbSellForiegn($tpl_bb_sell_foriegn)
        {
            $this->tpl_bb_sell_foriegn = $tpl_bb_sell_foriegn;
        }

        function setSglHbFitLocal($sgl_hb_fit_local)
        {
            $this->sgl_hb_fit_local = $sgl_hb_fit_local;
        }

        function setSglHbSellLocal($sgl_hb_sell_local)
        {
            $this->sgl_hb_sell_local = $sgl_hb_sell_local;
        }

        function setSglHbFitForiegn($sgl_hb_fit_foriegn)
        {
            $this->sgl_hb_fit_foriegn = $sgl_hb_fit_foriegn;
        }

        function setSglHbSellForiegn($sgl_hb_sell_foriegn)
        {
            $this->sgl_hb_sell_foriegn = $sgl_hb_sell_foriegn;
        }

        function setDblHbFitLocal($dbl_hb_fit_local)
        {
            $this->dbl_hb_fit_local = $dbl_hb_fit_local;
        }

        function setDblHbSellLocal($dbl_hb_sell_local)
        {
            $this->dbl_hb_sell_local = $dbl_hb_sell_local;
        }

        function setDblHbFitForiegn($dbl_hb_fit_foriegn)
        {
            $this->dbl_hb_fit_foriegn = $dbl_hb_fit_foriegn;
        }

        function setDblHbSellForiegn($dbl_hb_sell_foriegn)
        {
            $this->dbl_hb_sell_foriegn = $dbl_hb_sell_foriegn;
        }

        function setTplHbFitLocal($tpl_hb_fit_local)
        {
            $this->tpl_hb_fit_local = $tpl_hb_fit_local;
        }

        function setTplHbSellLocal($tpl_hb_sell_local)
        {
            $this->tpl_hb_sell_local = $tpl_hb_sell_local;
        }

        function setTplHbFitForiegn($tpl_hb_fit_foriegn)
        {
            $this->tpl_hb_fit_foriegn = $tpl_hb_fit_foriegn;
        }

        function setTplHbSellForiegn($tpl_hb_sell_foriegn)
        {
            $this->tpl_hb_sell_foriegn = $tpl_hb_sell_foriegn;
        }

        function setSglFbFitLocal($sgl_fb_fit_local)
        {
            $this->sgl_fb_fit_local = $sgl_fb_fit_local;
        }

        function setSglFbSellLocal($sgl_fb_sell_local)
        {
            $this->sgl_fb_sell_local = $sgl_fb_sell_local;
        }

        function setSglFbFitForiegn($sgl_fb_fit_foriegn)
        {
            $this->sgl_fb_fit_foriegn = $sgl_fb_fit_foriegn;
        }

        function setSglFbSellForiegn($sgl_fb_sell_foriegn)
        {
            $this->sgl_fb_sell_foriegn = $sgl_fb_sell_foriegn;
        }

        function setDblFbFitLocal($dbl_fb_fit_local)
        {
            $this->dbl_fb_fit_local = $dbl_fb_fit_local;
        }

        function setDblFbSellLocal($dbl_fb_sell_local)
        {
            $this->dbl_fb_sell_local = $dbl_fb_sell_local;
        }

        function setDblFbFitForiegn($dbl_fb_fit_foriegn)
        {
            $this->dbl_fb_fit_foriegn = $dbl_fb_fit_foriegn;
        }

        function setDblFbSellForiegn($dbl_fb_sell_foriegn)
        {
            $this->dbl_fb_sell_foriegn = $dbl_fb_sell_foriegn;
        }

        function setTplFbFitLocal($tpl_fb_fit_local)
        {
            $this->tpl_fb_fit_local = $tpl_fb_fit_local;
        }

        function setTplFbSellLocal($tpl_fb_sell_local)
        {
            $this->tpl_fb_sell_local = $tpl_fb_sell_local;
        }

        function setTplFbFitForiegn($tpl_fb_fit_foriegn)
        {
            $this->tpl_fb_fit_foriegn = $tpl_fb_fit_foriegn;
        }

        function setTplFbSellForiegn($tpl_fb_sell_foriegn)
        {
            $this->tpl_fb_sell_foriegn = $tpl_fb_sell_foriegn;
        }

        function setSglAiFitLocal($sgl_ai_fit_local)
        {
            $this->sgl_ai_fit_local = $sgl_ai_fit_local;
        }

        function setSglAiSellLocal($sgl_ai_sell_local)
        {
            $this->sgl_ai_sell_local = $sgl_ai_sell_local;
        }

        function setSglAiFitForiegn($sgl_ai_fit_foriegn)
        {
            $this->sgl_ai_fit_foriegn = $sgl_ai_fit_foriegn;
        }

        function setSglAiSellForiegn($sgl_ai_sell_foriegn)
        {
            $this->sgl_ai_sell_foriegn = $sgl_ai_sell_foriegn;
        }

        function setDblAiFitLocal($dbl_ai_fit_local)
        {
            $this->dbl_ai_fit_local = $dbl_ai_fit_local;
        }

        function setDblAiSellLocal($dbl_ai_sell_local)
        {
            $this->dbl_ai_sell_local = $dbl_ai_sell_local;
        }

        function setDblAiFitForiegn($dbl_ai_fit_foriegn)
        {
            $this->dbl_ai_fit_foriegn = $dbl_ai_fit_foriegn;
        }

        function setDblAiSellForiegn($dbl_ai_sell_foriegn)
        {
            $this->dbl_ai_sell_foriegn = $dbl_ai_sell_foriegn;
        }

        function setTplAiFitLocal($tpl_ai_fit_local)
        {
            $this->tpl_ai_fit_local = $tpl_ai_fit_local;
        }

        function setTplAiSellLocal($tpl_ai_sell_local)
        {
            $this->tpl_ai_sell_local = $tpl_ai_sell_local;
        }

        function setTplAiFitForiegn($tpl_ai_fit_foriegn)
        {
            $this->tpl_ai_fit_foriegn = $tpl_ai_fit_foriegn;
        }

        function setTplAiSellForiegn($tpl_ai_sell_foriegn)
        {
            $this->tpl_ai_sell_foriegn = $tpl_ai_sell_foriegn;
        }

        function setDiscountRatesUpForiegn($discount_rates_up_foriegn)
        {
            $this->discount_rates_up_foriegn = $discount_rates_up_foriegn;
        }

//TODO:Calculate rate using bed type/meal type/currency type

        function setDiscountRatesUpLocal($discount_rates_up_local)
        {
            $this->discount_rates_up_local = $discount_rates_up_local;
        }

        //------------------------//

        function setHotelPriceMinLocal($hotel_price_min_local)
        {
            $this->hotel_price_min_local = $hotel_price_min_local;
        }

        function setHotelPriceMinForiegn($hotel_price_min_foriegn)
        {
            $this->hotel_price_min_foriegn = $hotel_price_min_foriegn;
        }

        function setModifiedDate($modified_date)
        {
            $this->modified_date = $modified_date;
        }

        function newHotelRoomRate()
        {
            $status = $this->MDatabase->insert($this->table_name, array(
                "hotel_id"                  => $this->hotelId(),
                "hotel_room_type_id"        => $this->hotelRoomTypeId(),
                "period_name"               => $this->periodName(),
                "date_in"                   => $this->dateIn(),
                "date_out"                  => $this->dateOut(),
                "sgl_ro_fit_local"          => $this->sglRoFitLocal(),
                "sgl_ro_sell_local"         => $this->sglRoSellLocal(),
                "sgl_ro_fit_foriegn"        => $this->sglRoFitForiegn(),
                "sgl_ro_sell_foriegn"       => $this->sglRoSellForiegn(),
                "dbl_ro_fit_local"          => $this->dblRoFitLocal(),
                "dbl_ro_fit_foriegn"        => $this->dblRoFitForiegn(),
                "dbl_ro_sell_foriegn"       => $this->dblRoSellForiegn(),
                "tpl_ro_fit_local"          => $this->tplRoFitLocal(),
                "tpl_ro_sell_local"         => $this->tplRoSellLocal(),
                "tpl_ro_fit_foriegn"        => $this->tplRoFitForiegn(),
                "tpl_ro_sell_foriegn"       => $this->tplRoSellForiegn(),
                "sgl_bb_fit_local"          => $this->sglBbFitLocal(),
                "sgl_bb_sell_local"         => $this->sglBbSellLocal(),
                "sgl_bb_fit_foriegn"        => $this->sglBbFitForiegn(),
                "sgl_bb_sell_foriegn"       => $this->sglBbSellForiegn(),
                "dbl_bb_fit_local"          => $this->dblBbFitLocal(),
                "dbl_bb_sell_local"         => $this->dblBbSellLocal(),
                "dbl_bb_fit_foriegn"        => $this->dblBbFitForiegn(),
                "dbl_bb_sell_foriegn"       => $this->dblBbSellForiegn(),
                "tpl_bb_fit_local"          => $this->tplBbFitLocal(),
                "tpl_bb_sell_local"         => $this->tplBbSellLocal(),
                "tpl_bb_fit_foriegn"        => $this->tplBbFitForiegn(),
                "tpl_bb_sell_foriegn"       => $this->tplBbSellForiegn(),
                "sgl_hb_fit_local"          => $this->sglHbFitLocal(),
                "sgl_hb_sell_local"         => $this->sglHbSellLocal(),
                "sgl_hb_fit_foriegn"        => $this->sglHbFitForiegn(),
                "sgl_hb_sell_foriegn"       => $this->sglHbSellForiegn(),
                "dbl_hb_fit_local"          => $this->dblHbFitLocal(),
                "dbl_hb_sell_local"         => $this->dblHbSellLocal(),
                "dbl_hb_fit_foriegn"        => $this->dblHbFitForiegn(),
                "dbl_hb_sell_foriegn"       => $this->dblHbSellForiegn(),
                "tpl_hb_fit_local"          => $this->tplHbFitLocal(),
                "tpl_hb_sell_local"         => $this->tplHbSellLocal(),
                "tpl_hb_fit_foriegn"        => $this->tplHbFitForiegn(),
                "tpl_hb_sell_foriegn"       => $this->tplHbSellForiegn(),
                "sgl_fb_fit_local"          => $this->sglFbFitLocal(),
                "sgl_fb_sell_local"         => $this->sglFbSellLocal(),
                "sgl_fb_fit_foriegn"        => $this->sglFbFitForiegn(),
                "sgl_fb_sell_foriegn"       => $this->sglFbSellForiegn(),
                "dbl_fb_fit_local"          => $this->dblFbFitLocal(),
                "dbl_fb_sell_local"         => $this->dblFbSellLocal(),
                "dbl_fb_fit_foriegn"        => $this->dblFbFitForiegn(),
                "dbl_fb_sell_foriegn"       => $this->dblFbSellForiegn(),
                "tpl_fb_fit_local"          => $this->tplFbFitLocal(),
                "tpl_fb_sell_local"         => $this->tplFbSellLocal(),
                "tpl_fb_fit_foriegn"        => $this->tplFbFitForiegn(),
                "tpl_fb_sell_foriegn"       => $this->tplFbSellForiegn(),
                "sgl_ai_fit_local"          => $this->sglAiFitLocal(),
                "sgl_ai_sell_local"         => $this->sglAiSellLocal(),
                "sgl_ai_fit_foriegn"        => $this->sglAiFitForiegn(),
                "sgl_ai_sell_foriegn"       => $this->sglAiSellForiegn(),
                "dbl_ai_fit_local"          => $this->dblAiFitLocal(),
                "dbl_ai_sell_local"         => $this->dblAiSellLocal(),
                "dbl_ai_fit_foriegn"        => $this->dblAiFitForiegn(),
                "dbl_ai_sell_foriegn"       => $this->dblAiSellForiegn(),
                "tpl_ai_fit_local"          => $this->tplAiFitLocal(),
                "tpl_ai_sell_local"         => $this->tplAiSellLocal(),
                "tpl_ai_fit_foriegn"        => $this->tplAiFitForiegn(),
                "tpl_ai_sell_foriegn"       => $this->tplAiSellForiegn(),
                "discount_rates_up_foriegn" => $this->discountRatesUpForiegn(),
                "discount_rates_up_local"   => $this->discountRatesUpLocal(),
                "hotel_price_min_local"     => $this->hotelPriceMinLocal(),
                "hotel_price_min_foriegn"   => $this->hotelPriceMinForiegn(),
                "modified_date"             => $this->modifiedDate()
            ));
            return $status;
        }

        function hotelId()
        {
            return $this->hotel_id;
        }

        function hotelRoomTypeId()
        {
            return $this->hotel_room_type_id;
        }

        function periodName()
        {
            return $this->period_name;
        }

        function dateIn()
        {
            return $this->date_in;
        }

        function dateOut()
        {
            return $this->date_out;
        }

        function sglRoFitLocal()
        {
            return $this->sgl_ro_fit_local;
        }

        function sglRoSellLocal()
        {
            return $this->sgl_ro_sell_local;
        }

        function sglRoFitForiegn()
        {
            return $this->sgl_ro_fit_foriegn;
        }

        function sglRoSellForiegn()
        {
            return $this->sgl_ro_sell_foriegn;
        }

        function dblRoFitLocal()
        {
            return $this->dbl_ro_fit_local;
        }

        function dblRoFitForiegn()
        {
            return $this->dbl_ro_fit_foriegn;
        }

        function dblRoSellForiegn()
        {
            return $this->dbl_ro_sell_foriegn;
        }

        function tplRoFitLocal()
        {
            return $this->tpl_ro_fit_local;
        }

        function tplRoSellLocal()
        {
            return $this->tpl_ro_sell_local;
        }

        function tplRoFitForiegn()
        {
            return $this->tpl_ro_fit_foriegn;
        }

        function tplRoSellForiegn()
        {
            return $this->tpl_ro_sell_foriegn;
        }

        function sglBbFitLocal()
        {
            return $this->sgl_bb_fit_local;
        }

        function sglBbSellLocal()
        {
            return $this->sgl_bb_sell_local;
        }

        function sglBbFitForiegn()
        {
            return $this->sgl_bb_fit_foriegn;
        }

        function sglBbSellForiegn()
        {
            return $this->sgl_bb_sell_foriegn;
        }

        function dblBbFitLocal()
        {
            return $this->dbl_bb_fit_local;
        }

        function dblBbSellLocal()
        {
            return $this->dbl_bb_sell_local;
        }

        function dblBbFitForiegn()
        {
            return $this->dbl_bb_fit_foriegn;
        }

        function dblBbSellForiegn()
        {
            return $this->dbl_bb_sell_foriegn;
        }

        function tplBbFitLocal()
        {
            return $this->tpl_bb_fit_local;
        }

        function tplBbSellLocal()
        {
            return $this->tpl_bb_sell_local;
        }

        function tplBbFitForiegn()
        {
            return $this->tpl_bb_fit_foriegn;
        }

        function tplBbSellForiegn()
        {
            return $this->tpl_bb_sell_foriegn;
        }

        function sglHbFitLocal()
        {
            return $this->sgl_hb_fit_local;
        }

        function sglHbSellLocal()
        {
            return $this->sgl_hb_sell_local;
        }

        function sglHbFitForiegn()
        {
            return $this->sgl_hb_fit_foriegn;
        }

        function sglHbSellForiegn()
        {
            return $this->sgl_hb_sell_foriegn;
        }

        function dblHbFitLocal()
        {
            return $this->dbl_hb_fit_local;
        }

        function dblHbSellLocal()
        {
            return $this->dbl_hb_sell_local;
        }

        function dblHbFitForiegn()
        {
            return $this->dbl_hb_fit_foriegn;
        }

        function dblHbSellForiegn()
        {
            return $this->dbl_hb_sell_foriegn;
        }

        function tplHbFitLocal()
        {
            return $this->tpl_hb_fit_local;
        }

        function tplHbSellLocal()
        {
            return $this->tpl_hb_sell_local;
        }

        function tplHbFitForiegn()
        {
            return $this->tpl_hb_fit_foriegn;
        }

        function tplHbSellForiegn()
        {
            return $this->tpl_hb_sell_foriegn;
        }

        function sglFbFitLocal()
        {
            return $this->sgl_fb_fit_local;
        }

        function sglFbSellLocal()
        {
            return $this->sgl_fb_sell_local;
        }

        function sglFbFitForiegn()
        {
            return $this->sgl_fb_fit_foriegn;
        }

        function sglFbSellForiegn()
        {
            return $this->sgl_fb_sell_foriegn;
        }

        function dblFbFitLocal()
        {
            return $this->dbl_fb_fit_local;
        }

        function dblFbSellLocal()
        {
            return $this->dbl_fb_sell_local;
        }

        function dblFbFitForiegn()
        {
            return $this->dbl_fb_fit_foriegn;
        }

        function dblFbSellForiegn()
        {
            return $this->dbl_fb_sell_foriegn;
        }

        function tplFbFitLocal()
        {
            return $this->tpl_fb_fit_local;
        }

        function tplFbSellLocal()
        {
            return $this->tpl_fb_sell_local;
        }

        function tplFbFitForiegn()
        {
            return $this->tpl_fb_fit_foriegn;
        }

        function tplFbSellForiegn()
        {
            return $this->tpl_fb_sell_foriegn;
        }

        function sglAiFitLocal()
        {
            return $this->sgl_ai_fit_local;
        }

        function sglAiSellLocal()
        {
            return $this->sgl_ai_sell_local;
        }

        function sglAiFitForiegn()
        {
            return $this->sgl_ai_fit_foriegn;
        }

        function sglAiSellForiegn()
        {
            return $this->sgl_ai_sell_foriegn;
        }

        function dblAiFitLocal()
        {
            return $this->dbl_ai_fit_local;
        }

        function dblAiSellLocal()
        {
            return $this->dbl_ai_sell_local;
        }

        function dblAiFitForiegn()
        {
            return $this->dbl_ai_fit_foriegn;
        }

        function dblAiSellForiegn()
        {
            return $this->dbl_ai_sell_foriegn;
        }

        function tplAiFitLocal()
        {
            return $this->tpl_ai_fit_local;
        }

        function tplAiSellLocal()
        {
            return $this->tpl_ai_sell_local;
        }

        function tplAiFitForiegn()
        {
            return $this->tpl_ai_fit_foriegn;
        }

        function tplAiSellForiegn()
        {
            return $this->tpl_ai_sell_foriegn;
        }

        function discountRatesUpForiegn()
        {
            return $this->discount_rates_up_foriegn;
        }

        function discountRatesUpLocal()
        {
            return $this->discount_rates_up_local;
        }

        function hotelPriceMinLocal()
        {
            return $this->hotel_price_min_local;
        }

        //TODO:Calculate rate using bed type/meal type/currency type

        function hotelPriceMinForiegn()
        {
            return $this->hotel_price_min_foriegn;
        }

        function modifiedDate()
        {
            return $this->modified_date;
        }

        function updateHotelRoomRate()
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "hotel_id"                  => $this->hotelId(),
                "hotel_room_type_id"        => $this->hotelRoomTypeId(),
                "period_name"               => $this->periodName(),
                "date_in"                   => $this->dateIn(),
                "date_out"                  => $this->dateOut(),
                "sgl_ro_fit_local"          => $this->sglRoFitLocal(),
                "sgl_ro_sell_local"         => $this->sglRoSellLocal(),
                "sgl_ro_fit_foriegn"        => $this->sglRoFitForiegn(),
                "sgl_ro_sell_foriegn"       => $this->sglRoSellForiegn(),
                "dbl_ro_fit_local"          => $this->dblRoFitLocal(),
                "dbl_ro_sell_local"         => $this->dblRoSellLocal(),
                "dbl_ro_fit_foriegn"        => $this->dblRoFitForiegn(),
                "dbl_ro_sell_foriegn"       => $this->dblRoSellForiegn(),
                "tpl_ro_fit_local"          => $this->tplRoFitLocal(),
                "tpl_ro_sell_local"         => $this->tplRoSellLocal(),
                "tpl_ro_fit_foriegn"        => $this->tplRoFitForiegn(),
                "tpl_ro_sell_foriegn"       => $this->tplRoSellForiegn(),
                "sgl_bb_fit_local"          => $this->sglBbFitLocal(),
                "sgl_bb_sell_local"         => $this->sglBbSellLocal(),
                "sgl_bb_fit_foriegn"        => $this->sglBbFitForiegn(),
                "sgl_bb_sell_foriegn"       => $this->sglBbSellForiegn(),
                "dbl_bb_fit_local"          => $this->dblBbFitLocal(),
                "dbl_bb_sell_local"         => $this->dblBbSellLocal(),
                "dbl_bb_fit_foriegn"        => $this->dblBbFitForiegn(),
                "dbl_bb_sell_foriegn"       => $this->dblBbSellForiegn(),
                "tpl_bb_fit_local"          => $this->tplBbFitLocal(),
                "tpl_bb_sell_local"         => $this->tplBbSellLocal(),
                "tpl_bb_fit_foriegn"        => $this->tplBbFitForiegn(),
                "tpl_bb_sell_foriegn"       => $this->tplBbSellForiegn(),
                "sgl_hb_fit_local"          => $this->sglHbFitLocal(),
                "sgl_hb_sell_local"         => $this->sglHbSellLocal(),
                "sgl_hb_fit_foriegn"        => $this->sglHbFitForiegn(),
                "sgl_hb_sell_foriegn"       => $this->sglHbSellForiegn(),
                "dbl_hb_fit_local"          => $this->dblHbFitLocal(),
                "dbl_hb_sell_local"         => $this->dblHbSellLocal(),
                "dbl_hb_fit_foriegn"        => $this->dblHbFitForiegn(),
                "dbl_hb_sell_foriegn"       => $this->dblHbSellForiegn(),
                "tpl_hb_fit_local"          => $this->tplHbFitLocal(),
                "tpl_hb_sell_local"         => $this->tplHbSellLocal(),
                "tpl_hb_fit_foriegn"        => $this->tplHbFitForiegn(),
                "tpl_hb_sell_foriegn"       => $this->tplHbSellForiegn(),
                "sgl_fb_fit_local"          => $this->sglFbFitLocal(),
                "sgl_fb_sell_local"         => $this->sglFbSellLocal(),
                "sgl_fb_fit_foriegn"        => $this->sglFbFitForiegn(),
                "sgl_fb_sell_foriegn"       => $this->sglFbSellForiegn(),
                "dbl_fb_fit_local"          => $this->dblFbFitLocal(),
                "dbl_fb_sell_local"         => $this->dblFbSellLocal(),
                "dbl_fb_fit_foriegn"        => $this->dblFbFitForiegn(),
                "dbl_fb_sell_foriegn"       => $this->dblFbSellForiegn(),
                "tpl_fb_fit_local"          => $this->tplFbFitLocal(),
                "tpl_fb_sell_local"         => $this->tplFbSellLocal(),
                "tpl_fb_fit_foriegn"        => $this->tplFbFitForiegn(),
                "tpl_fb_sell_foriegn"       => $this->tplFbSellForiegn(),
                "sgl_ai_fit_local"          => $this->sglAiFitLocal(),
                "sgl_ai_sell_local"         => $this->sglAiSellLocal(),
                "sgl_ai_fit_foriegn"        => $this->sglAiFitForiegn(),
                "sgl_ai_sell_foriegn"       => $this->sglAiSellForiegn(),
                "dbl_ai_fit_local"          => $this->dblAiFitLocal(),
                "dbl_ai_sell_local"         => $this->dblAiSellLocal(),
                "dbl_ai_fit_foriegn"        => $this->dblAiFitForiegn(),
                "dbl_ai_sell_foriegn"       => $this->dblAiSellForiegn(),
                "tpl_ai_fit_local"          => $this->tplAiFitLocal(),
                "tpl_ai_sell_local"         => $this->tplAiSellLocal(),
                "tpl_ai_fit_foriegn"        => $this->tplAiFitForiegn(),
                "tpl_ai_sell_foriegn"       => $this->tplAiSellForiegn(),
                "discount_rates_up_foriegn" => $this->discountRatesUpForiegn(),
                "discount_rates_up_local"   => $this->discountRatesUpLocal(),
                "hotel_price_min_local"     => $this->hotelPriceMinLocal(),
                "hotel_price_min_foriegn"   => $this->hotelPriceMinForiegn(),
                "modified_date"             => $this->modifiedDate()
            ), array("room_rate_id" => $this->roomRateId()));
            //echo $this->MDatabase->sqlquery; die();
            return $status;

        }

        function dblRoSellLocal()
        {
            return $this->dbl_ro_sell_local;
        }

        function roomRateId()
        {
            return $this->room_rate_id;
        }

        function updateHotelRoomRateMax()
        {
            $status = $this->MDatabase->update($this->table_name, array(
                "discount_rates_up_foriegn" => $this->discountRatesUpForiegn(),
                "discount_rates_up_local"   => $this->discountRatesUpLocal(),
                "hotel_price_min_local"     => $this->hotelPriceMinLocal(),
                "hotel_price_min_foriegn"   => $this->hotelPriceMinForiegn()

            ), array("room_rate_id" => $this->roomRateId()));
            return $status;
        }

        function getRateFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "room_rate_id='" . $this->roomRateId() . "'");
            return $this->MDatabase->result;
        }

        function getMinRoomPrices()
        {
            $this->MDatabase->select($this->table_name, "MIN(hotel_price_min_local),MIN(hotel_price_min_foriegn)", "hotel_id='" . $this->hotelId() . "'");
            $res = $this->MDatabase->result;
            return $res;
        }

        function getMaxDiscountRates()
        {
            $this->MDatabase->select($this->table_name, "MAX(discount_rates_up_local),MAX(discount_rates_up_foriegn)", "hotel_id='" . $this->hotelId() . "'");
            $res = $this->MDatabase->result;
            return $res;
        }

        function getColoumNames()
        {
            $this->MDatabase->custom($this->table_name, "SHOW COLUMNS FROM room_rates");
            return $this->MDatabase->result;
        }

        function getRatesFromHotelId()
        {
            $this->MDatabase->select($this->table_name, "*", "hotel_id='" . $this->hotelId() . "'"," date_in, date_out ");
            return $this->MDatabase->result;
        }

        function getRatesFromRateId()
        {
            $this->MDatabase->select($this->table_name, "*", "room_rate_id='" . $this->roomRateId() . "'");
            return $this->MDatabase->result;
        }

        function getAllRatesForDates($date_in, $date_out, $room_type_id){
            //$this->MDatabase->select($this->table_name, "*", "date_in <= '".$date_in."' AND date_out >= '".$date_out."' AND hotel_room_type_id = '".$room_type_id."'");
            $this->MDatabase->select($this->table_name, "*", "date_out >= '".$date_in."' AND date_in <= '".$date_out."' AND hotel_room_type_id = '".$room_type_id."'");
            return $this->MDatabase->result;
        }

        function checkRateInRoomType($bedType, $mealType, $room_count, $booked_from_date, $booked_to_date)
        {
            $FIT_RATE = $bedType . '_' . $mealType . '_fit_' . $_SESSION['ipLocation'];
            $SELL_RATE = $bedType . '_' . $mealType . '_sell_' . $_SESSION['ipLocation'];

            //$this->MDatabase->select($this->table_name,"$FIT_RATE,$SELL_RATE","hotel_room_type_id='".$this->hotelRoomTypeId()."' AND date_in<='".COUNTRY_DATE."' AND date_out>='".COUNTRY_DATE."'");
            //$res = $this->MDatabase->result;

            $this->MDatabase->select($this->table_name, "$FIT_RATE,$SELL_RATE", "hotel_room_type_id='" . $this->hotelRoomTypeId() . "' AND (date_in <= '" . $booked_from_date . "' AND date_out >= '" . $booked_to_date . "') ");
            $res = $this->MDatabase->result;
            // $amount=number_format($res[0]["$SELL_RATE"], 2, ',', ' ')

            //$amount = number_format ($res[0]["$SELL_RATE"]);
            $amount = $res[0]["$SELL_RATE"];
            $total = $amount * $room_count;
            // $total_view = number_format($total);
            echo round($total);
        }

        function getRateInRoomTypeForDates($bedType, $mealType)
        {
            $SELL_RATE = $bedType . '_' . $mealType . '_sell_' . $_SESSION['ipLocation'];
            $this->MDatabase->select($this->table_name, "$SELL_RATE", "hotel_room_type_id='" . $this->hotelRoomTypeId() . "' AND date_in<='" . $this->date_in . "' AND date_out>='" . $this->date_out . "'");
            $res = $this->MDatabase->result;
            $amount = $res[0]["$SELL_RATE"];
            return $amount;
        }

        function getRateInRoomType($bedType, $mealType)
        {
            $check_in_date = date('Y-m-d', strtotime($_SESSION['check_in_date']));
            $FIT_RATE = $bedType . '_' . $mealType . '_fit_' . $_SESSION['ipLocation'];
            $SELL_RATE = $bedType . '_' . $mealType . '_sell_' . $_SESSION['ipLocation'];

            $this->MDatabase->select($this->table_name, "$FIT_RATE,$SELL_RATE", "hotel_room_type_id='" . $this->hotelRoomTypeId() . "' AND date_in<='" . $check_in_date . "' AND date_out>='" . $check_in_date . "'");
            //$this->MDatabase->select($this->table_name, "$FIT_RATE,$SELL_RATE", "hotel_room_type_id='" . $this->hotelRoomTypeId() . "' AND date_in<='" . COUNTRY_DATE . "' AND date_out>='" . COUNTRY_DATE . "'");
            $res = $this->MDatabase->result;

            $amount = $res[0]["$SELL_RATE"];
            return $amount;
        }

        function getRateInRoomTypeForDate($bedType, $mealType,$date)
        {
            $date = date('Y-m-d', strtotime($date));
            $FIT_RATE = $bedType . '_' . $mealType . '_fit_' . $_SESSION['ipLocation'];
            $SELL_RATE = $bedType . '_' . $mealType . '_sell_' . $_SESSION['ipLocation'];
            $this->MDatabase->select($this->table_name, "$FIT_RATE,$SELL_RATE", "hotel_room_type_id='" . $this->hotelRoomTypeId() . "' AND '" . $date . "' BETWEEN date_in AND date_out");
            $res = $this->MDatabase->result;
            $amount = $res[0]["$SELL_RATE"];
            return $amount;
        }

        function checkRateInRoomTypeOnlinePay($bedType, $mealType, $room_count, $booked_from_date, $booked_to_date)
        {
            $FIT_RATE = $bedType . '_' . $mealType . '_fit_' . $_SESSION['ipLocation'];
            $SELL_RATE = $bedType . '_' . $mealType . '_sell_' . $_SESSION['ipLocation'];

            $this->MDatabase->select($this->table_name, "$FIT_RATE,$SELL_RATE", "hotel_room_type_id='" . $this->hotelRoomTypeId() . "' AND (date_in <= '" . $booked_from_date . "' AND date_out >= '" . $booked_to_date . "') ");
            $res = $this->MDatabase->result;
            //$amount = number_format ($res[0]["$SELL_RATE"], 2);

            $day = 86400;
            $startTime = strtotime($booked_from_date);
            $endTime = strtotime($booked_to_date);
            $numDays = round(($endTime - $startTime) / $day);

            $amount = $res[0]["$SELL_RATE"];
            return ($amount * $room_count * $numDays);

        }

        function getAgentRate($sellingRate)
        {
            $hotels_rates_value = Sessions::getHotelRatesEditHotelId();

            $agentRate = 0;
            $nettRate = 0;

            $rates_value = (100 - $hotels_rates_value) / 100;
            $agentRate = $sellingRate * $rates_value;
            //$nettRate		= $agentRate;
            $agentRate = round($agentRate, 2);
            echo($agentRate);
        }

        function setValues($data)
        {

            foreach ($data as $k => $v) {
                $this->$k = $v;
            }

        }

        function getFieldValue($fieldName){
            return $this->$fieldName;
        }

        function ratesDeleteById()
        {
            $status = $this->MDatabase->delete($this->table_name, "room_rate_id='" . $this->roomRateId() . "'");
            return $status;
        }

        function ratesDeleteByRateId($rateIds)
        {
            foreach ($rateIds as $k => $rate_id) {
                if(!$this->MDatabase->delete($this->table_name, "room_rate_id='" . $rate_id . "'")){
                    return false;
                }
            }
            return true;
        }

        function getDatesBetween2Dates($startTime, $endTime)
        {
            $day = 86400;
            $format = 'Y-m-d';
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            $numDays = round(($endTime - $startTime) / $day);
            $days = array();
            for ($i = 0; $i < $numDays; $i++) {
                $days[] = date($format, ($startTime + ($i * $day)));
            }
            return $days;
        }

        function getDatesBetween2DatesOffer($startTime, $endTime)
        {
            $day = 86400;
            $format = 'Y-m-d';
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            $numDays = round(($endTime - $startTime) / $day);
            $days = array();
            for ($i = 0; $i <= $numDays; $i++) {
                $days[] = date($format, ($startTime + ($i * $day)));
            }
            return $days;
        }

        function getRoomRatesForDatesAndRoomId($date, $bedType, $mealType)
        {
            $FIT_RATE = $bedType . '_' . $mealType . '_fit_' . $_SESSION['ipLocation'];
            $SELL_RATE = $bedType . '_' . $mealType . '_sell_' . $_SESSION['ipLocation'];

            $this->MDatabase->select($this->table_name, "$FIT_RATE,$SELL_RATE", "hotel_room_type_id='" . $this->hotelRoomTypeId() . "' AND date_in<='" . $date . "' AND date_out>='" . $date . "'");
            $res = $this->MDatabase->result;

            $amount = $res[0]["$SELL_RATE"];
            return $amount;
        }


    }

?>