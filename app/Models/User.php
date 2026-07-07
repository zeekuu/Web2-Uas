<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, LogsActivity;
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected $primaryKey = 'idUser';
        protected $guarded = ['idUser'];
    protected $fillable = [
    'nama',
    'nim',
    'email',
    'password',
    'role',
];

    public function Event()
    {
        return $this->hasMany(Event::class, 'idUser');
    }

    public function Transaksi()
    {
        return $this->hasMany(Transaksi::class, 'idUser');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Otomatis mencatat perubahan pada kolom $fillable
            ->logOnlyDirty() // Hanya mencatat kolom yang datanya benar-benar berubah
            ->dontLogEmptyChanges(); // Mencegah log kosong tersimpan
    }

}
