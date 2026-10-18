<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alat extends Model
{
    protected $table = 'alat';

protected $fillable = [
    'nama_alat',
    'jumlah',
    'kategori_id',
    'foto',
];

public function booking(): HasMany
{
    return $this->hasMany(Booking::class, 'alat_id');
}
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
