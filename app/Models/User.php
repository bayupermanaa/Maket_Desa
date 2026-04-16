<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',           // Tambahan: masyarakat, admin_desa, kepala_desa
        'nik',            // Untuk masyarakat
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper untuk cek role
    public function isMasyarakat() { return $this->role === 'masyarakat'; }
    public function isAdmin()      { return $this->role === 'admin_desa'; }
    public function isKepalaDesa() { return $this->role === 'kepala_desa'; }
}