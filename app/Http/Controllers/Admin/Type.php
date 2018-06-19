<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Type as Mtype;

class Type extends Controller
{
    public function getType()
    {
        $listType = Mtype::all()->toArray();
        $listType = collect($listType);
        $data['listType'] = $listType->sortBy('orders')->values()->all();
        return view('Admin.Type',$data);
    }

    public function doEdit(Request $req)
    {
        $type = Mtype::find($req->id);
        if ($type) {
            $type->type_name = $req->type_name;
            $result = $type->save();
        }
        else{
            $result = Mtype::create($req->all());
        }
        echo $result;
        exit;
    }

    public function detectID(Request $req)
    {
        $id = $req->id;
        $rs = Mtype::find($id)->foods()->get()->toArray();
        echo count($rs);
        exit;
    }
    
    public function confirmDelete(Request $req)
    {
        $type = Mtype::find($req->typeId)->foods()->detach();
        Mtype::find($req->typeId)->delete();
        return redirect('/admin/type/')->with('success','This item has been remove!');
    }
    
    public function sort(Request $req)
    {
        $arrSTT = collect(json_decode($req->arr, true));
        $arrSTT->map(function($i,$k){
            $up = Mtype::find($i['id']);
            $up->orders = $i['orders'];
            $up->save();
        });
        echo 1;
        exit;
    }
}
