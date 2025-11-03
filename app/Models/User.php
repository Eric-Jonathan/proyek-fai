<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'user';

    protected $fillable = [
    'username',
    'email',
    'password',
    'jabatan',
    'atasan_id',
    'hak_akses',
];

    protected $hidden = [
        'password',
    ];

    // Relasi self-join untuk atasan
    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    public function bawahan()
    {
        return $this->hasMany(User::class, 'atasan_id');
    }
}
