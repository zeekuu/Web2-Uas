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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('idTransaksi');
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('idEvent');
            $table->foreign('idEvent')->references('idEvent')->on('events')->onDelete('cascade');
            
            $table->string('buktiTransfer')->nullable(); 
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('qr_code')->nullable(); 
            $table->boolean('kehadiran')->default(false);
            $table->timestamp('waktuHadir')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
