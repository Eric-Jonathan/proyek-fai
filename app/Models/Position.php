<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';
    protected $primaryKey = 'position_id';

    public $timestamps = false;

    protected $fillable = [
        'position_code',
        'position_name',
        'parent_position_id',
        'hierarchy_level',
        'position_type',
        'division_code',
        'bureau_name',
    ];

    // ============================
    // RELATIONS
    // ============================

    public function parent()
    {
        return $this->belongsTo(Position::class, 'parent_position_id');
    }

    public function children()
    {
        return $this->hasMany(Position::class, 'parent_position_id');
    }

    public function assignments()
    {
        return $this->hasMany(PositionAssignment::class, 'position_id');
    }

    public function signedSurat()
    {
        return $this->hasMany(SuratTugas::class, 'signed_by_position_id');
    }
}
