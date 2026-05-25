<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $primaryKey = 'id_nota';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_nota', 'tanggal', 'total_jumlah', 'nopol', 'id_petugas_admin', 'id_petugas_mekanik'];

    protected $casts = ['tanggal' => 'date'];

    public function motor()
    {
        return $this->belongsTo(Motor::class, 'nopol', 'nopol');
    }

    public function admin()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_admin', 'id_petugas');
    }

    public function mekanik()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_mekanik', 'id_petugas');
    }

    public function details()
    {
        return $this->hasMany(DetailNota::class, 'id_nota', 'id_nota');
    }
}
