<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    public $timestamps = false;   // tabel pengembalian tidak punya created_at / updated_at

    protected $fillable = [
        'booking_id',
        'tanggal_kembali',
        'denda',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}