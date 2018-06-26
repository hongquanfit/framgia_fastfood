<?php

namespace App\Http\Controllers\FE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Model\Food;
use App\Model\Rate;

class RatingController extends Controller
{
    public function rateFood(Request $req)
    {
        $ss = Auth::user();
        $food = Food::find($req->foodId);
        $change = $food->users()->sync([
            $ss->id => [
                'score' => $req->rate,
                'time' => time()
            ],
        ]);
        
        return $change;
    }
}
