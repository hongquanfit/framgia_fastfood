<?php

namespace App\Http\Controllers\FE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Food;

class HomeController extends Controller
{
    public function index()
    {
        $food = Food::whereHas('foodStatus', function($query){
                        $query->where('status', 'Good');
                    })->orderBy('total_score', 'DESC')
                    ->with('types:types')
                    ->with('addresses')
                    ->get()
                    ->toArray();
                    
        foreach ($food as $key => $item) {
            $food[$key]['rateStar'] = renderStar($item['total_score']);
        }
        $data['headItem'] = array_shift($food);
        $data['listItem'] = $food;
        
        return view('FE.home', $data);
    }
}
