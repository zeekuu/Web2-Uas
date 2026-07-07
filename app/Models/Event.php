<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Event extends Model
{
    use LogsActivity;
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
        'status',
        'rekening'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function Transaksi()
    {
        return $this->hasMany(Transaksi::class, 'idEvent', 'idEvent');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Otomatis mencatat perubahan pada kolom $fillable
            ->logOnlyDirty() // Hanya mencatat kolom yang datanya benar-benar berubah
            ->dontLogEmptyChanges(); // Mencegah log kosong tersimpan
    }

}
