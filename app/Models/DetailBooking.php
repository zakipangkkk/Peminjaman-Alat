<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBooking extends Model
{
    protected $table = 'detail_booking';

    protected $fillable = ['booking_id', 'alat_id', 'jumlah'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
}