<?php

namespace App\Http\Controllers;

use App\Models\SuratTugas;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dosen_dashboard(){
        $user = session('user');

        if ($user['role'] == 'dekan'){
            $surat = SuratTugas::where('status_surat','>=',2)->where('status_surat','<=',3)->get();
        }
        else{
            $surat = SuratTugas::where('status_surat','>=',0)->where('nidn', '=', $user['nidn'])->get();
        }

        return view('dosen_kaprodi.index', compact('surat'));
    }
}
