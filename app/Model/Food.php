<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'food', 
        'description', 
        'city', 
        'total_score', 
        'rate_times',
    ];

    public function images()
    {
        return $this->hasMany(App\Model\Image::class);
    }

    public function comments()
    {
        return $this->hasMany(App\Model\Comment::class);
    }

    public function foodStatus()
    {
        return $this->belongsTo(App\Model\FoodStatus::class);
    }
    
    public function foodUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function types()
    {
        return $this->belongsToMany(App\Model\Type::class);
    }

     public function addresses()
    {
        return $this->belongsToMany(App\Model\Address::class);
    }

    public function nutritions()
    {
        return $this->belongsToMany(App\Model\Nutrition::class);
    } 

    public function users()
    {
        return $this->belongsToMany(User::class, 'rates');
    }
}
