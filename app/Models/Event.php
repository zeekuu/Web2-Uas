<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'idEvent';
    protected $guarded = ['idEvent'];

    protected $fillable = [
        'idUser',
        'namaEvent',
        'tempatEvent',
        'deskripsi',
        'tanggalEvent',
        'waktuEvent',
        'kuotaPeserta',
        'hargaTiket',
        'fileProposal',
        'alasan',
        'poster',
        'status'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function Transaksi()
    {
        return $this->hasMany(Transaksi::class, 'idEvent', 'idEvent');
    }

}
