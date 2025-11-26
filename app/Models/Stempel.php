<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stempel extends Model
{
    use HasFactory;

    protected $table = 'stempel';
    protected $primaryKey = 'stempel_id';
    public $timestamps = false;

    protected $fillable = [
        'nidn',
        'stempel_image_path',
        'valid_until',
    ];

    protected $casts = [
        'valid_until' => 'date',
    ];

    public function issuer()
    {
        return $this->belongsTo(Lecturer::class, 'nidn', 'nidn');
    }
}
