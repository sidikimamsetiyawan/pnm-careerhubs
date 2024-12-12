<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleModel;

class RoleController extends Controller
{
    public function list()
    {
        $data['getRecord'] = RoleModel::getRecord();
        return view('role.list', $data);
    }

    public function add()
    {  
        return view('role.add');
    }

    public function insert(Request $request)
    {
        // dd($request->all());
        $save = new RoleModel;
        $save->name = $request->name;
        $save->save();

        return redirect('panel/role')->with('suceess', "Role has been successfully created.");
    }

    public function edit($id)
    {  
        $data['getRecord'] = RoleModel::getSingle($id);
        return view('role.edit',$data);
    }

    public function update($id, Request $request)
    {
        // dd($request->all());
        $save = RoleModel::getSingle($id);
        $save->name = $request->name;
        $save->save();

        return redirect('panel/role')->with('suceess', "Role has been successfully updated.");
    }

    
    public function delete($id)
    {
         // dd($request->all());
         $save = RoleModel::getSingle($id);
         $save->delete();
 
         return redirect('panel/role')->with('suceess', "Role has been successfully deleted.");
    }
}
