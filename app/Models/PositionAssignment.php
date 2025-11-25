<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PositionAssignment extends Model
{
    use HasFactory;

    protected $table = 'position_assignments';
    protected $primaryKey = 'position_assignment_id';

    public $timestamps = false;

    protected $fillable = [
        'position_id',
        'nidn',
        'start_date',
        'end_date',
        'decree_number',
        'assignment_status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'assignment_status' => 'integer',
    ];

    // ============================
    // RELATIONS
    // ============================

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'nidn', 'nidn');
    }
}
