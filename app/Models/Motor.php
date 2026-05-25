<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    protected $primaryKey = 'nopol';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nopol', 'id_customer'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}
