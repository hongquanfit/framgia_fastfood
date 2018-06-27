<?php

namespace App\Http\Controllers\FE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Model\Food;
use App\Model\Rate;
use App\Model\Comment;

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
        $allScore = Rate::where('food_id', $req->foodId)->get();
        $food->total_score = $allScore->sum('score');
        $food->rate_times = count($allScore);
        $food->save();

        $returnArray = [
            'total_score' => $allScore->sum('score'),
            'rate_times' => count($allScore),
            'star' => renderStar($allScore->sum('score'), count($allScore)),
        ];
        
        if ($change > 0) {
            return json_encode($returnArray);
        } else {
            return 0;
        }
    }

    public function comment(Request $req)
    {
        $req->merge([
            'food_id' => $req->foodId,
            'time' => time(),
            'user_id' => Auth::user()->id,
        ]);
        $result = Comment::create($req->all())->wasRecentlyCreated;

        return (int) $result;
    }
}
