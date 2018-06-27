<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Food;
use App\Model\Address;

class ApiController extends Controller
{
    public function findFood($food)
    {
        return Food::where('food', 'like', "%$food%")->with([
            'addresses',
            'images',
        ])->get();
    }

    public function findAddress($address)
    {
        return Address::where('address', 'like', "%$address%")->get();
    }
}
