<?php

namespace App\Http\Controllers\FE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Food;
use App\Model\Type;
use App\Model\Address;
use App\Model\Image;
use App\Model\FoodType;
use App\Model\Homepage;
use App\Model\Favorite;

class HomeController extends Controller
{
    public function index($typeId=null)
    {
        $homepage = Homepage::getOptions();
        $food = Food::toGetListFood('total_score', 'DESC')->toArray();
        $foodNewest = Food::toGetListFood('create_at', 'DESC')->toArray();
        $favoriteFood = Favorite::where('user_id', Auth::user()->id)->get()->pluck('food_id')->toArray();
        $favoriteList = Food::toGetListFood('total_score', 'DESC', $favoriteFood)->toArray();
        $food = $this->renderArrayFood($food);
        $food = collect($food)->sortByDesc('avrRate')->toArray();
        $foodNewest = $this->renderArrayFood($foodNewest);
        $favoriteList = $this->renderArrayFood($favoriteList);

        $data['headItem'] = array_shift($food);
        $data['listItem'] = $food;
        $data['listType'] = Type::all()->toArray();
        $data['foodNewest'] = $foodNewest;
        $data['favoriteList'] = $favoriteList;
        $data['allowHeadBoard'] = $homepage['banner']['display'];
        $data['allowBottom'] = true;
        
        return view('FE.home', $data);
    }

    public function renderArrayFood($food)
    {
        foreach ($food as $key => $item) {
            $food[$key]['rateStar'] = renderStar($item['total_score'], $item['rate_times']);
            $food[$key]['avrRate'] = ($item['rate_times'] == 0) ? 0 : $item['total_score'] / $item['rate_times'];
        }

        return $food;
    }

    public function searchByType($by = null, $id = null)
    {
        switch ($by) {
            case 'allrandom':
                return $this->allRandom();
                break;
            case 'withtype':
                return $this->onlyType(1, $id);
                break;
            case 'onlytype':
                $type = Type::all()->toArray();
                foreach ($type as $key => $value) {
                    $newType[$value['id']] = $value['types'];
                }
                $data['listItem'] = $this->onlyType(0, $id);
                $data['listType'] = Type::all()->toArray();
                $data['selectType'] = $newType;
                $data['allowHeadBoard'] = false;
                $data['allowBottom'] = false;

                return view('FE.home', $data);
                break;
        }
    }

    public function doSuggest(Request $req)
    {
        if (!checkCharacter($req->food)) {
            return back()->with('fail', __('You have entered a not allow character'));
        }
        $req->merge([
            'user_id' => Auth::user()->id,
            'create_at' => time(),
        ]);
        
        if ($req->submit == 'insert') {
            try {
                $id = Food::create($req->all())->id;
            } catch (Exception $e) {

                return redirect('/')->with('fail', __('suggestFail'));
            }
            
            $food = Food::find($id);
            $food->types()->attach($req->food_type);

            if ($req->hasFile('hideImg')) {
                $ava = $req->file('hideImg');
                $name = $ava->getClientOriginalName();
                $name = time() . '_' . $name;
                $ava->move(config('app.imagesUrl'), $name);
                $image = new Image([
                    'url' => $name,
                ]);
                $food->images()->save($image);
            }
        }
        else {
            $id = explode('_', $req->submit)[1];
            $food = Food::find($id);
        }

        $groupAddress = ($req->address) ? $req->address : $req->price;
        $address = $req->address;
        $price = $req->price;

        if ($groupAddress) {
            for ($i = 0; $i < count($groupAddress); $i++) {
                $arrayAddress = [];
                $arrayAddress['address'] = $address[$i];
                $arrayAddress['price'] = $price[$i];
                $arrayAddress['user_id'] = Auth::user()->id;
                $arrayIdAddress[] = Address::create($arrayAddress)->id;
            }
        }

        $touch = $food->addresses()->attach($arrayIdAddress);

        return redirect('/')->with('success', __('suggestSuccess'));
    }

    //function
    public function onlyType($type, $id)
    {
        $arrayId = $id ? explode('_', $id) : [];

        if ($arrayId) {
            $typeId = FoodType::whereIn('type_id', $arrayId)->get()->pluck('food_id')->toArray();
            $searched = Food::whereIn('id', $typeId)->whereHas('foodStatus', function($query){
                        $query->where('status', 'Displaying');
                    })->orderBy('total_score', 'DESC')
                    ->with('types:types')
                    ->with('addresses')
                    ->with('images')
                    ->get()
                    ->toArray();

            foreach ($searched as $key => $item) {
                $searched[$key]['rateStar'] = renderStar($item['total_score'], $item['rate_times']);
            }
        }
        else {
            $searched = [];
        }

        if ($type) {
            return json_encode(array_random($searched));
        }
        else {
            return $searched;
        }
    }

    public function allRandom()
    {
        $searched = Food::whereHas('foodStatus', function($query){
                        $query->where('status', 'Displaying');
                    })->orderBy('total_score', 'DESC')
                    ->with('types:types')
                    ->with('addresses')
                    ->with('images')
                    ->get()
                    ->toArray();

        foreach ($searched as $key => $item) {
            $searched[$key]['rateStar'] = renderStar($item['total_score'], $item['rate_times']);
        }

        return json_encode(array_random($searched));
    }
}
