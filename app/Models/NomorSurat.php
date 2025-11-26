<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomorSurat extends Model
{
    protected $table = 'nomor_surat';
    protected $primaryKey = 'nomor_id';

    protected $fillable = [
        'tahun',
        'nomor_terakhir'
    ];

    public $timestamps = false;
}
