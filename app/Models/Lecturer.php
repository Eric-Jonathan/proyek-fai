<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Lecturer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'lecturers';

    protected $fillable = [
        'username',
        'password',
        'email',
        'role',
        'full_name',
        'lecturer_code',
        'nidn',
        'employment_status',
        'start_date',
        'end_date',
        'is_certified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_certified' => 'boolean',
    ];

    /* =====================================================
     |  RELATIONSHIPS
     ===================================================== */

    // Many-to-many permissions
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'lecturers_permissions',
            'lecturer_id',
            'permission_id'
        );
    }

    // Lecturer → Surat Tugas (relasi via NIDN)
    public function suratTugas()
    {
        return $this->hasMany(SuratTugas::class, 'nidn', 'nidn');
    }

    // Lecturer → Stempel (via NIDN)
    public function stempel()
    {
        return $this->hasMany(Stempel::class, 'nidn', 'nidn');
    }

    // Lecturer → Log Aktivitas (via NIDN)
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'nidn', 'nidn');
    }

    public function activePositionAssignment()
{
    return $this->hasOne(PositionAssignment::class, 'nidn', 'nidn')
                ->where('assignment_status', 1)
                ->orderBy('start_date', 'desc')
                ->with('position');
}
    public function activePositions()
{
    return $this->hasMany(PositionAssignment::class, 'nidn', 'nidn')
                ->where('assignment_status', 1);
}
public function activePosition()
{
    $assignment = $this->activePositions()->with('position')->first();
    return $assignment?->position;
}
public function positionAssignment()
{
    return $this->hasOne(PositionAssignment::class, 'nidn', 'nidn')
                ->orderBy('start_date', 'desc'); 
}

}
