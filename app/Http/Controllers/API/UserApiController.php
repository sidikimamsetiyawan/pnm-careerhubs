<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::getRecord();

            // dd($users->all());
    
            return response()->json([
                'status' => true,
                'message' => 'Data retrieved users successfully.',
                'result' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve users.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
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

            $tokenResult = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Created user has been successfully.',
                'result' => $user,
                'access_token' => $tokenResult
            ], 200);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json([
                'status' => false,
                'message' => 'Created user has been failed.',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $users = User::getSingle($id);

            // dd($users->all());
    
            return response()->json([
                'status' => true,
                'message' => 'Get Data retrieved user successfully.',
                'result' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
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

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved user successfully.',
                'result' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $save = User::getSingle($id);
            $save->hobbies()->detach();
            $save->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data user has been deleted.',
                'result' => $save
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed delete user data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
