<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    // protected $table = 'surat_tugas';
    // protected $primaryKey = 'surat_id';
    
    // // Kolom yang boleh diisi (Mass Assignment)
    // protected $fillable = [
    //     'employee_nip',
    //     'template_id',
    //     'nama_kegiatan',
    //     'tanggal_mulai',
    //     'tanggal_selesai',
    //     'tempat_kegiatan',
    //     'lampiran_path',
    //     'status_surat',
    //     'nomor_surat_final',
    //     'signed_by_position_id'
    // ];

    // /**
    //  * Relasi ke tabel lecturers (Penganju Surat)
    //  * FK: employee_nip (di surat_tugas) -> employee_nip (di lecturers)
    //  */
    // public function lecturer()
    // {
    //     // Parameter ke-2: FK di tabel ini, Parameter ke-3: Key di tabel tujuan
    //     return $this->belongsTo(Lecturer::class, 'employee_nip', 'employee_nip');
    // }

    // /**
    //  * Relasi ke tabel surat_templates
    //  * FK: template_id
    //  */
    // public function template()
    // {
    //     return $this->belongsTo(SuratTemplate::class, 'template_id', 'template_id');
    // }

    // /**
    //  * Relasi ke tabel positions (Pejabat Penanda Tangan)
    //  * FK: signed_by_position_id
    //  */
    // public function signedByPosition()
    // {
    //     return $this->belongsTo(Position::class, 'signed_by_position_id', 'position_id');
    // }
}