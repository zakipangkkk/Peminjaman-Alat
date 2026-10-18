<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        schema::create('pengembalian', function(Blueprint $table){
            $table->id();
            $table->foreIgnId('booking_id')->constrained('booking')->casecadeOnDelete();
            $table->date('tanggal_kembali');
            $table->decimal('denda');
            $table->string('keterangan');
            $table->string('status');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
