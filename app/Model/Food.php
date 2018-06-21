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
        'user_id',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function foodStatus()
    {
        return $this->belongsTo(FoodStatus::class);
    }
    
    public function foodUser()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function types()
    {
        return $this->belongsToMany(Type::class, 'food_types');
    }

     public function addresses()
    {
        return $this->belongsToMany(Address::class, 'address_foods');
    }

    public function nutritions()
    {
        return $this->belongsToMany(Nutrition::class);
    } 

    public function users()
    {
        return $this->belongsToMany('App\User', 'rates');
    }
}
