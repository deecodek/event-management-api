<?php

namespace App\Trait;

use Barryvdh\DomPDF\Facade\Pdf;

trait PdfGenerator
{
    public function generatePdf($data, $view, $filename)
    {
        $pdf = Pdf::loadView($view, $data);

        return $pdf->download($filename);
    }
}
