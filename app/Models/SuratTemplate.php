<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratTemplate extends Model
{
    use HasFactory;

    protected $table = 'surat_templates';
    protected $primaryKey = 'template_id';
    public $timestamps = true;

    protected $fillable = [
        'template_name',
        'file_path',
        'template_type',
    ];

    public function suratTugas()
    {
        return $this->hasMany(SuratTugas::class, 'template_id');
    }
}
