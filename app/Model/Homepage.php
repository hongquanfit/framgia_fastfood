<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Homepage extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'banner',
        'middle',
        'bottom',
    ];

    public function scopeGetOptions()
    {
        $array = Homepage::find(1)->toArray();
        $homepage['banner'] = json_decode($array['banner'], true);
        $homepage['middle'] = json_decode($array['middle'], true);
        $homepage['bottom'] = json_decode($array['bottom'], true);

        return $homepage;
    }
}
