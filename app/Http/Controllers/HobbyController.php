<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HobbyModel;

class HobbyController extends Controller
{
    public function list()
    {
        $data['getRecord'] = HobbyModel::getRecord();
        return view('hobby.list', $data);
    }

    public function add()
    {  
        return view('hobby.add');
    }

    public function insert(Request $request)
    {
        // dd($request->all());
        $save = new HobbyModel;
        $save->hobby_name = $request->hobby_name;
        $save->save();

        return redirect('panel/hobby')->with('suceess', "Hobby has been successfully created.");
    }
}
