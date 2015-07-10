<?php
/**
 * Created by PhpStorm.
 * User: Seevali
 * Date: 2014-08-15
 * Time: 09:33
 */

    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "Log":
            Log();
            break;
    }

    function Log(){

    }