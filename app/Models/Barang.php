<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_barang',
        'nama',
        'jenis',
        'stok',
        'harga_beli',
        'harga_jual',
        'diskon',
    ];
}
