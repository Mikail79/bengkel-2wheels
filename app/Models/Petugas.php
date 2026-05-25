<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $primaryKey = 'id_petugas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_petugas', 'nama', 'jabatan'];
}
