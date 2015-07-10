<?php

    class Libs
    {
        private static $rating = array(0 => "No Rating", 1 => "1", 2 =>  "2", 3 =>  "3", 4 =>  "4", 5 =>  "5", 6 =>  "6", 7 =>  "7");

        private static $bed_type = array("sgl" => 'Single', "dbl" => 'Double', "tpl" => 'Triple');
        private static $bed_type_resevation = array("sgl" => 'sgl', "dbl" => 'dbl', "tpl" => 'tpl');

        private static $meal_type = array("ro" => 'Room Only', "bb" => 'Bed & Breakfast', "hb" => 'Half Board', "fb" => 'Full Board');
        private static $meal_type_resevation = array("ro" => 'ro', "bb" => 'bb', "hb" => 'hb', "fb" => 'fb', "ai" => 'ai');

        private static $all_status = array("Visible", "Hidden");

        private static $hotel_status_admin = array(0=> "Inactive", 1=> "Active", 2=> "Deactivation Pending", 3=> "Deactivated");
        private static $hotel_status_normal = array(0=> "Inactive", 1=> "Active", 2=> "Deactivation Pending");

        private static $dis_type = array("Fixed", "Percentage", "Free Nights", "Custom");

        private static $hotel_sections = array(0 => "Property Details", 1 => "Hotel Style", 2 => "Hotel Facilities", 3 => "Room Types - Add", 4 => "Room Types - Edit", 5 => "Room Types - Delete", 6 => "Useful Info", 7 => "Hotel Rates - Add", 8 => "Hotel Rates - Edit", 9 => "Hotel Rates - Delete", 10 => "Assign Room", 11 => "Hotel Images", 12 => "", 13 => "Special Offers - Add", 14 => "Special Offers - Edit", 15 => "Special Offers - Delete", 16 => "Other");


        static function get($lib)
        {
            return self::$$lib;
        }

        static function getKey($lib,$value)
        {
            return array_search($value, self::$$lib);
        }

        static function getValue($lib,$key)
        {
            $arr=(array)self::$$lib;
            return $arr[$key];
        }
    }