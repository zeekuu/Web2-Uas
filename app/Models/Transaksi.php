<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $primaryKey = 'idTransaksi';
    protected $fillable = ['idUser', 'idEvent', 'buktiTransfer', 'status', 'qr_code', 'kehadiran', 'waktuHadir'];
    protected $table = 'transaksis';
    public function User()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }
    public function Event()
    {
        return $this->belongsTo(Event::class, 'idEvent', 'idEvent');
    }
}
