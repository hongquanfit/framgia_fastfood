<?php

namespace App\Http\Controllers\FE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Model\Food;
use App\Model\Type;
use App\Model\Comment;
use App\User;
use App\Model\Address;
use App\Model\Rate;

class DetailsController extends Controller
{
    public function show($info = null)
    {
        $foodId = explode('_', $info)[1];
        $food = Food::toShowDetails($foodId)->with('rates:score,time')->get();
        $rate = Rate::where('food_id', $foodId)->get()->toArray();

        foreach ($food as $key => $item) {
            $food[$key]['rateStar'] = renderStar($item['total_score'], $item['rate_times']);
            $food[$key]['countComment'] = count($item['comments']);
            $adr = $item['addresses']->toArray();

            if ($adr) {
                if (count($adr) == 1) {
                    $food[$key]['price'] = $adr[0]['price'];
                } else {
                    $food[$key]['price'] = number_format($adr[0]['price'], 0) . ' VND - ' . number_format($adr[count($adr) - 1]['price'], 0);
                }
            } else {
                $food[$key]['price'] = '???';
            }
        }

        $listAddress = $food->toArray()[0]['addresses'];
        
        foreach ($listAddress as $key => $adr) {
            $listAddress[$key]['rateStar'] = renderStar($adr['total_score'], $adr['rate_times']);
            $getUser = User::where('id', $adr['user_id']);
            $listAddress[$key]['whoAdded'] = $getUser ? $getUser->get()->toArray()[0] : [];
        }

        $type = Type::all()->toArray();
        $data['headItem'] = $food->toArray()[0];
        $data['listType'] = $type;
        $data['headAddress'] = $listAddress;
        $data['currency'] = [
            'VND',
            'USD',
        ];

        return view('FE.Details', $data);
    }

    public function addAddress(Request $req)
    {
        $req->merge([
            'user_id' => Auth::user()->id,
        ]);

        if ($req->hasFile('adrAvatar')) {
            $ava = $req->file('adrAvatar');
            $name = $ava->getClientOriginalName();
            $name = time() . '_' . $name;
            $ava->move(config('app.imagesUrl'), $name);
            $req->merge([
                'avatar' => $name,
            ]);
        } else {
            $req->merge([
                'avatar' => '',
            ]);
        }
        
        $id = Address::create($req->all())->id;

        try {
            $change = Food::findOrFail($req->food)->addresses()->attach($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('fail', __('suggestFail'));
        }

        return back()->with('success', __('suggestSuccess'));
    }
}
