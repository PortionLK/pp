<?php
/**
 * Created by PhpStorm.
 * User: Seevali
 * Date: 2014-07-31
 * Time: 14:01
 */
include DOC_ROOT . "libraries/phpqrcode/qrlib.php";

class QRCodeGen {

    public static function getCode($data)
    {
        if (trim($data) == '')
            $data="roomista.com";
        //ob_implicit_flush(false); //just in case
       // ob_start();
        echo  QRcode::png($data);
        //$output = base64_encode(ob_get_contents());
       // ob_end_clean();
        //return $output;
    }
	
	
	
/*	
    public static function getCode($data)
    {
        if (trim($data) == '')
            $data="roomista.com";
        ob_implicit_flush(false); //just in case
        ob_start();
        QRcode::png($data);
        $output = base64_encode(ob_get_contents());
        ob_end_clean();
        return $output;
    }
	
	
*/	
	
	
	
	
}