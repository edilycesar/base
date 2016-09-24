<?php

require_once '../core/opt/mpdf60/mpdf.php';

/**
 * Description of PDFHelper.
 *
 * @author edily
 */
class PDF
{
    public function make($contentHtml, $destination)
    {
        $pdf = new mPDF();
        $pdf->WriteHTML($contentHtml);

        return $pdf->Output($destination);
    }
}
