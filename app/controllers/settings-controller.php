<?php
/**
 * Created by PhpStorm.
 * User: Seevali
 * Date: 9/16/14
 * Time: 2:28 PM
 */

    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];
    switch ($action) {

        case "updateSettings":
            updateSettings();
            break;
    }


    function updateSettings()
    {
        $sysSettings = new systemSetting();
        $get_edited = array();
        foreach ($_REQUEST as $k => $v) {
            $get_edited[$k] = $v;
        }
        $sysSettings->setValues($get_edited);
        if ($sysSettings->editSetting()) {
            Common::jsonSuccess("Settings Update Successfully!");
        } else {
            Common::jsonError("Error");
        }
    }
