<?php
/**
 * Created by PhpStorm.
 * User: Seevali
 * Date: 2014-07-30
 * Time: 17:10
 */

    require_once('mPDF/mpdf.php');

    $orientation = strtoupper("L");
    $paperSize =strtoupper("L");

    $pdf = new mpdf('',    // mode - default ''
        strtoupper($paperSize),    // format - A4, for example, default ''
        0,     // font size - default 0
        'segoeui',    // default font family
        $printMargins->getLeft()*15,    // margin_left
        $printMargins->getRight()*15,    // margin right
        $printMargins->getTop()*15,     // margin top
        $printMargins->getBottom()*15,    // margin bottom
        0,     // margin header
        0,     // margin footer
        $orientation         // L - landscape, P - portrait
    );

    $pdf->AddPage($orientation);

    //  Document info
    $pdf->SetTitle("Customer Invoice");
    $pdf->SetAuthor("roomista.com");
    $pdf->SetSubject("Customer Invoice");
    $pdf->SetKeywords("Customer Invoice");
    $pdf->SetCreator("roomista.com");

    $pdf->WriteHTML(
        $this->generateHTMLHeader(FALSE) .
        $this->generateSheetData() .
        $this->generateHTMLFooter()
    );

    //  Write to file
    fwrite($fileHandle, $pdf->Output('', 'S'));