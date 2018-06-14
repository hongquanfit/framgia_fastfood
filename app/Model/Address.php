<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamp = false;
    protected $fillable = [
    	'id', 
    	'address', 
    	'phone',
    ];

    public function foods()
    {
        return $this->belongsToMany(App\Model\Food::class);
    }
}
