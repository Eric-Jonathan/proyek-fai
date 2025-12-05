<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';
    protected $primaryKey = 'log_id';
    public $timestamps = false;

    protected $fillable = [
        'nidn',
        'aktivitas',
        'module',
        'module_id',
        'keterangan',
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'nidn', 'nidn');
    }
}