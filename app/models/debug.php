<?php

    /**
     * Created by PhpStorm.
     * User: Seevali
     * Date: 5/16/2014
     * Time: 3:14 PM
     */
    class Debug
    {

        public static function log($data)
        {
            if (is_array($data)) {
                $values = array_map('array_pop', $data);
                echo("<script>console.log('PHP: " . implode(', ', $values) . "');</script>");
            } else {
                echo("<script>console.log('PHP: " . $data . "');</script>");
            }
        }
    }