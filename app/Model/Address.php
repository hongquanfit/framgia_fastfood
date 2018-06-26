<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'address',
        'price',
        'phone',
    ];

    public function foods()
    {
        return $this->belongsToMany(Food::class);
    }
}
