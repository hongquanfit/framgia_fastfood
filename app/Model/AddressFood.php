<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddressFood extends Model
{
    public $timestamps = false;
    protected $fillable = ['address_id','food_id'];
}
