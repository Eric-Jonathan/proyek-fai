<?php

namespace App\Http\Controllers;

use App\Models\SuratTugas;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dosen_dashboard(){
        $user = session('user');
        $surat = SuratTugas::where('status_surat','>=',0)->where('nidn', '=', $user['nidn'])->get();
        return view('dosen_kaprodi.index', compact('surat'));
    }
}
