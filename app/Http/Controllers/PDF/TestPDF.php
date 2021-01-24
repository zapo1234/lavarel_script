<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inscription;

class TestPDF extends Controller
{
    //

    public function generate(){
     
    $data = Inscription::get();
    $filename = 'country_list.pdf';
    $mpdf = new \Mpdf\Mpdf([
    'margin-left'=>10,
    'margin-top'=>10,
    'margin-bottom'=>20

    ]);

    $html = \View::make('pdf.demo')->with('data', $data);
    $html = $html->render();

    $mpdf->writeHTML($html);
    $mpdf->Output($filename, 'I');


    }
}
