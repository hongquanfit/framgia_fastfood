<?php

namespace App\Http\Controllers\FE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Type;
use App\Model\Food;
use App\Model\Favorite;
use App\Model\History;
use App\User;

class UserController extends Controller
{
    public function showProfile()
    {
        $bmi = $_COOKIE['userBMI'] ? json_decode($_COOKIE['userBMI'], true) : '';

        $listFavo = Favorite::select('food_id')->where('user_id', Auth::user()->id)->get()->pluck('food_id');
        $favorite = Food::toGetListFood('total_score', 'DESC', $listFavo, 9999)->toArray();
        $favorite = $this->renderArrayFood($favorite);
        $data['listItem'] = $favorite;
        $data['listType'] = Type::all();

        $calo = caloCaculation($bmi['calo']);
        $food = Food::whereBetween('total_calorie', [$calo - 100, $calo + 100])
                ->toGetListFood('total_calorie', 'DESC')->toArray();
        $closestCaloArr = [];

        for ($i = 0; $i < count($food); $i++) {
            $close = $this->getClosest($calo, $food);
            $closestCaloArr[] = $close['array'];
            unset($food[$close['key']]);
        }
        $closestCaloArr = $this->renderArrayFood($closestCaloArr);
        $data['listByCalorie'] = $closestCaloArr;

        $interactionFood = History::where('user_id', Auth::user()->id)->get()->pluck('food_id')->toArray();
        $countInteractionFood = array_count_values($interactionFood);
        $mostInteractionKey = $this->getMostInteractionKey($countInteractionFood);
        $mostInteractionItem = Food::toGetListFood('total_score', 'DESC', $mostInteractionKey)->toArray();
        $mostInteractionItem = $this->renderArrayFood($mostInteractionItem);
        $data['mostInteractionItem'] = $mostInteractionItem;

        return view('FE.profile', $data);
    }

    public function editProfile(Request $req)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $req->name;
        $user->save();

        return back();
    }

    public function renderArrayFood($food)
    {
        foreach ($food as $key => $item) {
            $food[$key]['rateStar'] = renderStar($item['total_score'], $item['rate_times']);
            $food[$key]['avrRate'] = ($item['rate_times'] == 0) ? 0 : $item['total_score'] / $item['rate_times'];
            $adr = $item['addresses'];

            if ($adr) {
                if (count($adr) == 1) {
                    $food[$key]['price'] = number_format($adr[0]['price'], 0) . ' VND';
                } else {
                    $food[$key]['price'] = number_format($adr[0]['price'], 0) . ' VND - ' . number_format($adr[count($adr) - 1]['price'], 0) . ' VND';
                }
            } else {
                $food[$key]['price'] = '???';
            }
        }

        return $food;
    }

    public function getMostInteractionKey($arr)
    {
        $arrayKey = [];
        do {
            $key = array_search(max($arr), $arr);
            $arrayKey[] = $key;
            unset($arr[$key]);
        } while (count($arrayKey) < config('app.interactionItemShow'));

        return $arrayKey;
    }

    public function getClosest($search, $arr)
    {
       $closest = null;
       $closestKey = null;
       foreach ($arr as $key => $item) {
            if ($closest === null || abs($search - $closest) > abs($item['total_calorie'] - $search)) {
                $closest = $item['total_calorie'];
                $closestArr = $item;
                $closestKey = $key;
            }
        }

        return [
            'key' => $closestKey,
            'array' => $closestArr,
        ];
    }
}
