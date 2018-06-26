<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Model\Food;
use App\Model\Type;
use App\Model\FoodStatus;
use App\Model\Image;
use App\Model\FoodType;

class FoodController extends Controller
{
    public function getListFood()
    {
        $food = Food::orderBy('total_score', 'DESC')->with([
            'types',
            'addresses',
            'images',
            'foodStatus',
            'foodUser',
        ])->get()->toArray();

        $data['listType'] = Type::all();
        $data['listStatus'] = FoodStatus::all();
        $data['listFood'] = $food;

        return view('Admin.Food', $data);
    }

    public function editName(Request $req)
    {
        if (checkCharacter($req->name)) {
            try {
                $food = Food::find($req->id);
            } catch (Exception $e) {
                return 0;
            }

            $food->food = $req->name;
            $food->save();

            return 1;
        } else {
            return 0;
        }
    }

    public function changeAvatar(Request $req)
    {
        if ($req->hasFile('image')) {
            $ava = $req->file('image');
            $name = $ava->getClientOriginalName();
            $name = time() . '_' . $name;
            $ava->move(config('app.imagesUrl'), $name);
            $image = Image::where('food_id', $req->id)->get()->toArray();

            if ($image) {
                $imageId = Image::find($image[0]['id']);
                $imageId->url = $name;
                $imageId->save();
            }
            else {
                $food = Food::find($req->id);
                $image = new Image([
                    'url' => $name,
                ]);
                $food->images()->save($image);
            }

            return 1;
        } else {
            return 0;
        }
    }

    public function editType(Request $req)
    {
        try {
            $food = Food::find($req->id);
            $food->types()->sync($req->types);
        }
        catch (Exception $e) {
            return 0;
        }
        return 1;
    }

    public function changeStatus(Request $req)
    {
        try {
            $food = Food::findOrFail($req->foodId);
            $food->food_status_id = $req->statusId;
            $food->save();
        }
        catch (ModelNotFoundException $e) {
            return 0;
        }
        return 1;
    }

    public function sortBy($type, $rate, $status)
    {
        $idType = $type ? explode('_', $type) : $type;
        $scoreRate = $rate ? explode('_', $rate) : $rate;
        $idStatus = $status ? explode('_', $status) : $status;

        $food = new Food();
        if ($idType) {
            $foodId = FoodType::whereIn('type_id', $idType)->get()->pluck('food_id')->toArray();
            $food = $food->whereIn('id', $foodId);
        }

        if ($scoreRate) {
            $food = $food->whereRaw('total_score >= rate_times*' . min($scoreRate) . ' AND total_score <= rate_times*' . max($scoreRate) . ' AND total_score > 0');
        }

        if ($idStatus) {
            $food = $food->whereIn('food_status_id', $idStatus);
        }

        $food = $food->orderBy('total_score', 'DESC')->with([
            'types',
            'addresses',
            'images',
            'foodStatus',
            'foodUser',
        ]);

        $data['typeValue'] = is_array($idType) ? $idType : [$idType];
        $data['rateScore'] = is_array($scoreRate) ? $scoreRate : [$scoreRate];
        $data['statusValue'] = is_array($idStatus) ? $idStatus : [$idStatus];
        $data['listType'] = Type::all();
        $data['listStatus'] = FoodStatus::all();
        $data['listFood'] = $food->get()->toArray();

        return view('Admin.Food', $data);
    }
}
