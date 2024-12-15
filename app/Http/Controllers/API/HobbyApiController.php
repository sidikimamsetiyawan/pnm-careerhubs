<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HobbyModel;
use Illuminate\Http\Request;

class HobbyApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $hobbies = HobbyModel::getRecord();

            // dd($hobbies->all());
    
            return response()->json([
                'status' => true,
                'message' => 'Data retrieved hobbies successfully.',
                'result' => $hobbies
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data hobbies.',
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
            $save = new HobbyModel;
            $save->hobby_name = $request->hobby_name;
            $save->save();

            return response()->json([
                'status' => true,
                'message' => 'Created hobby has been successfully.',
                'result' => $save
            ], 200);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json([
                'status' => false,
                'message' => 'Created hobby has been failed.',
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
            $hobbies = HobbyModel::getSingle($id);
    
            return response()->json([
                'status' => true,
                'message' => 'Get Data retrieved hobby successfully.',
                'result' => $hobbies
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data hobby.',
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
            $save = HobbyModel::getSingle($id);
            $save->hobby_name = $request->hobby_name;
            $save->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Updated hobby has been successfully.',
                'result' => $save
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to updated hobby.',
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
            $save = HobbyModel::getSingle($id);
            $save->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data hobby has been deleted.',
                'result' => $save
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed delete hobby data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
