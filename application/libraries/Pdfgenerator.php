<?php

// reference the Dompdf namespace
use Dompdf\Dompdf;

class PdfGenerator{
    public function generate($html, $filename){
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');//landscape

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        //$dompdf->stream();
        $dompdf->stream($filename.'.pdf',array("Attachment"=>0));
    }
}
?>