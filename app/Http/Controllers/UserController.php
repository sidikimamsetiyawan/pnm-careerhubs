<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getRecord();
        return view('panel.user.list',$data);
    }

    public function add()
    {  
        $data['getRole'] = RoleModel::getRecord();
        return view('panel.user.add', $data);
    }

    public function insert(Request $request)
    {  
        request()->validate([
            'email' => 'required|email|unique:users',
        ]);
        // dd($request->all());
        $user = new User;
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->role_id = trim($request->role_id);
        $user->save();

        return redirect('panel/user')->with('suceess', "User has been successfully created.");
    }

}
