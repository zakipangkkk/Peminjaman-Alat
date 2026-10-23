<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_telfon',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


// Tambahkan method ini di dalam class User (app/Models/User.php).
// Dengan ini, semua tampilan yang memanggil $user->name tetap jalan,
// walaupun kolom di tabel user bernama "nama".

public function getNameAttribute(): ?string
{
    return $this->attributes['nama'] ?? null;   // <- ganti 'nama' kalau kolom Anda berbeda
}
}