<?php

namespace App\Http\Controllers\FE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AddressFood;

class Home extends Controller
{
    public function index()
    {
    	return view('welcome');
    }
}
