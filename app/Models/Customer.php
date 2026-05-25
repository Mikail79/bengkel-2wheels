<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'id_customer';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_customer', 'nama', 'kontak'];

    public function motors()
    {
        return $this->hasMany(Motor::class, 'id_customer', 'id_customer');
    }
}
