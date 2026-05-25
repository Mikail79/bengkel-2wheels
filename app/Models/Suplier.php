<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    protected $primaryKey = 'id_suplier';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_suplier', 'nama', 'alamat', 'sales'];
}
