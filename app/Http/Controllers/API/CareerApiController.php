<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CareerModel;
use Illuminate\Http\Request;

class CareerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $careers = CareerModel::getRecord();

            // dd($careers->all());
    
            return response()->json([
                'status' => true,
                'message' => 'Data retrieved careers successfully.',
                'result' => $careers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data careers.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $emp_id)
    {
        try {
            $employees = CareerModel::getSingle($emp_id);
    
            return response()->json([
                'status' => true,
                'message' => 'Get Data retrieved employee successfully.',
                'result' => $employees
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data employee.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
