<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Lecturer extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'lecturers';

    protected $fillable = [
        'username',
        'password',
        'email',
        'role',
        'atasan_id',
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
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_certified' => 'boolean',
    ];

    /* =====================================================
     |  RELATIONSHIPS
     ===================================================== */

    // relasi ke atasan (self reference)
    public function atasan()
    {
        return $this->belongsTo(Lecturer::class, 'atasan_id');
    }

    // relasi bawahannya
    public function bawahan()
    {
        return $this->hasMany(Lecturer::class, 'atasan_id');
    }

    // relasi permission many-to-many
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'lecturers_permissions',
            'lecturer_id',
            'permission_id'
        );
    }

    // relasi ke surat tugas
    public function suratTugas()
    {
        return $this->hasMany(SuratTugas::class, 'nidn', 'nidn');
    }

    // relasi ke stempel
    public function stempel()
    {
        return $this->hasMany(Stempel::class, 'nidn', 'nidn');
    }

    // relasi ke log aktivitas
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'nidn', 'nidn');
    }

    /* =====================================================
     |  ACCESSORS / MUTATORS (opsional)
     ===================================================== */

    // public function setPasswordAttribute($value)
    // {
    //     if ($value) {
    //         $this->attributes['password'] = bcrypt($value);
    //     }
    // }
}
