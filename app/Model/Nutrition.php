<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'name', 
    	'calorie', 
    	'water', 
    	'protein', 
    	'lipit', 
    	'glucozo', 
    	'vestable',
    ];

    public function foods()
    {
        return $this->belongsToMany(App\Model\Food::class);
    }
}
