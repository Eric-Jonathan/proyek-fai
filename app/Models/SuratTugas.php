<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratTugas extends Model
{
    use HasFactory;

    protected $table = 'surat_tugas';
    protected $primaryKey = 'surat_id';

    public $timestamps = true;

    protected $fillable = [
        'nidn',
        'template_id',
        'nomor_surat',  
        'jabatan',  
        'jenis_tugas',
        'dasar_tugas',
        'sifat',
        'tujuan',
        'waktu_pelaksanaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_surat',
        'lampiran_path',
        'status_surat',
        'nomor_surat_final',
        'signed_by_position_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_surat' => 'date',
    ];

    // ============================
    // RELATIONS
    // ============================

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'nidn', 'nidn');
    }

    public function template()
    {
        return $this->belongsTo(SuratTemplate::class, 'template_id');
    }

    public function signedByPosition()
    {
        return $this->belongsTo(Position::class, 'signed_by_position_id', 'position_id');
    }
}