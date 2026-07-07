<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Transaksi extends Model
{
    use LogsActivity;
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
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Otomatis mencatat perubahan pada kolom $fillable
            ->logOnlyDirty() // Hanya mencatat kolom yang datanya benar-benar berubah
            ->dontLogEmptyChanges(); // Mencegah log kosong tersimpan
    }
}
