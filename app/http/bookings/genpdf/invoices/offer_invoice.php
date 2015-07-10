<?php


    // r�cup�ration du contenu HTML
    ob_start();
    include(dirname(__FILE__) . '/res/offer_invoice_source.php');
    $content = ob_get_clean();

    // conversion HTML => PDF
    require_once(dirname(__FILE__) . '/../html2pdf.class.php');
    try {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'ISO-8859-15');
//		$html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_REQUEST['vuehtml']));
        $html2pdf->Output('invoice00.pdf');
    } catch (HTML2PDF_exception $e) {
        echo $e;
    }
	