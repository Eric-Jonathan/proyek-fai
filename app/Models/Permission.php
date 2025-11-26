<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $primaryKey = 'permission_id';

    public $timestamps = false;

    protected $fillable = [
        'permission_name',
        'description',
    ];

    /* =====================================================
     |  RELATIONSHIPS
     ===================================================== */

    // many-to-many with lecturers
    public function lecturers()
    {
        return $this->belongsToMany(
            Lecturer::class,
            'lecturers_permissions',
            'permission_id',
            'lecturer_id'
        );
    }
}
