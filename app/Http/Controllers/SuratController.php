<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    public function surat()
    {
        // Set options terlebih dahulu
        Pdf::setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
        ]);

        // Load view utama
        $pdf = Pdf::loadView('CRUD_Surat.cetak_surat', [
            // Data yang ingin dikirim ke view bisa ditaruh di sini
            // 'nama' => 'Erick'
        ]);

        // Download file
        return $pdf->download('surat_tugas.pdf');
    }
}
