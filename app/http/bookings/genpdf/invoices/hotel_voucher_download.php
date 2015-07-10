<?php
    if(session_id() == '') { //For versions of PHP < 5.4.0
        session_start();
    }

    //For versions of PHP >= 5.4.0
    /*if (session_status() == PHP_SESSION_NONE) {
    	session_start();
    }*/

    $_SESSION['reservation_id'] = $_REQUEST['reservation_id'];

    // r�cup�ration du contenu HTML
    ob_start();
    include(dirname(__FILE__) . '/res/voucher_source_download.php');
    $content = ob_get_clean();

    // conversion HTML => PDF
    require_once(dirname(__FILE__) . '/../html2pdf.class.php');
    try {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'ISO-8859-15');
//		$html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_REQUEST['vuehtml']));
        $html2pdf->Output('voucher.pdf');

    } catch (HTML2PDF_exception $e) {
        echo $e;
    }


?>