<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faktur extends Model
{
    protected $primaryKey = 'id_faktur';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_faktur',
        'no_faktur',
        'id_suplier',
        'id_petugas',
        'tanggal',
        'termin',
        'syarat_pembayaran',
        'sub_total',
        'diskon',
        'ppn',
        'total'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'id_suplier', 'id_suplier');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function details()
    {
        return $this->hasMany(DetailFaktur::class, 'id_faktur', 'id_faktur');
    }
}
