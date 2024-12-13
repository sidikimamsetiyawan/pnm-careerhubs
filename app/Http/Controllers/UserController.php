<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoleModel;
use App\Models\HobbyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list()
    {
        // $data['getRecord'] = User::getRecord();
         // Fetch users with their hobbies
        $data['getRecord'] = User::with('hobbies')->get();
        return view('panel.user.list',$data);
    }

    public function add()
    {  
        $data['getRole'] = RoleModel::getRecord();
        $data['getHobby'] = HobbyModel::getRecord();
        return view('panel.user.add', $data);
    }

    public function insert(Request $request)
    {  
        // dd($request->all());
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

         // Attach hobbies to the user in the pivot table
        $user->hobbies()->attach($request->input('hobby_id'));

        // return redirect('panel/user')->with('suceess', "User has been successfully created.");
        return redirect()->back()->with('success', 'User dan hobi berhasil disimpan!');
    }

    public function edit($id)
    {  
        // $data['getRecord'] = User::getSingle($id);
        $data['getRecord'] = User::with('hobbies')->findOrFail($id); 
        $data['getRole'] = RoleModel::getRecord();
        $data['getHobby'] = HobbyModel::getRecord();
        return view('panel.user.edit',$data);
    }

    public function update($id, Request $request)
    {  
        $user = User::getSingle($id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        if(!empty($request->password))
        {
            $user->password = Hash::make($request->password);
        }
        $user->role_id = trim($request->role_id);
        $user->save();

         // Sync hobbies in the pivot table
        $user->hobbies()->sync($request->input('hobby_id', [])); // Sync hobbies or detach all if empty

        return redirect('panel/user')->with('suceess', "User updated successfully.");
    }

    public function delete($id)
    {
         // dd($request->all());
         $save = User::getSingle($id);
         $save->hobbies()->detach();
         $save->delete();
 
         return redirect('panel/user')->with('suceess', "User and related hobbies deleted successfully.");
    }

}
