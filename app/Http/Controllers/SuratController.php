<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    public function surat(){
        $pdf = app(\Barryvdh\DomPDF\PDF::class);
        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
        ]);
        $pdf->loadView('CRUD_Surat.cetak_surat');

        return $pdf->download('surat_tugas.pdf');
    }
}
