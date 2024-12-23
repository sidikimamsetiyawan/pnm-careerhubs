<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CareerReportsApiController extends Controller
{
    public function report(Request $request)
    {
        // Filters
        // $regionalId = $request->input('regional_id');
        // $areaId = $request->input('area_id');
        // $unitId = $request->input('unit_id');
        // $startDate = $request->input('start_date');
        // $endDate = $request->input('end_date');
        $status = $request->input('status'); // Can be 'active', 'resigned', or 'both'

        try {
            $rootPositions = DB::table('positions')
            ->select(['position_id', 'position_name', 'parent_id'])
            ->whereNull('parent_id')
            ->get();
            // dd($rootPositions);

            $allData = [];

            foreach ($rootPositions as $root) {
                // Start with the root position
                $hierarchy = [
                    'position_id' => $root->position_id,
                    'position_name' => $root->position_name,
                    'FullHierarchy' => $root->position_name,
                    'areas' => [] // Initialize areas (not children)
                ];

                // Fetch children iteratively
                $areas = DB::table('positions')
                    ->select(['position_id', 'position_name', 'parent_id'])
                    ->where('parent_id', $root->position_id)
                    ->get();

                foreach ($areas as $area) {

                    $areaHierarchy= [
                        'position_id' => $area->position_id,
                        'position_name' => $area->position_name,
                        'FullHierarchy' => $hierarchy['FullHierarchy'] . ' -> ' . $area->position_name,
                        'units' => [] // Initialize units for the area
                    ];

                    // Fetch units for the area (e.g., Unit level)
                    $units = DB::table('positions')
                        ->select(['position_id', 'position_name', 'parent_id'])
                        ->where('parent_id', $area->position_id)
                        ->get();

                    // Add units to the area
                    foreach ($units as $unit) {
                        $areaHierarchy['units'][] = [
                            'position_id' => $unit->position_id,
                            'position_name' => $unit->position_name,
                            'FullHierarchy' => $areaHierarchy['FullHierarchy'] . ' -> ' . $unit->position_name
                        ];
                    }

                    // Add the area with its units to the root hierarchy
                    $hierarchy['areas'][] = $areaHierarchy;
                }

                // // Add to all data
                $allData[] = $hierarchy;
            }

            // dd($allData);
            $reports = [];
            foreach ($allData as $regionalNode) {
                $totalEmployeeRegional = 0; // Initialize active employee count for the regional
                $regionalReports = []; // To collect all areas under the regional

                $regionalId = $regionalNode['position_id'];
                $regionalName = $regionalNode['position_name'];
    
                foreach ($regionalNode['areas'] as $areaNode) {
                    $totalEmployeeArea = 0; // Initialize active employee count for the area
                    $areaReports = []; // To collect all units under the area

                    $areaId = $areaNode['position_id'];
                    $areaName = $areaNode['position_name'];
    
                    foreach ($areaNode['units'] as $unitNode) {
                        $unitId = $unitNode['position_id'];
                        $unitName = $unitNode['position_name'];
    
                        // Fetch career data for each unit
                        $careerData = DB::table('career_histories as ch')
                            ->leftJoin('positions as p', 'ch.position_id', '=', 'p.position_id')
                            ->leftJoin('employees as e', 'ch.emp_id', '=', 'e.emp_id')
                            ->select([
                                'e.emp_id',
                                'e.emp_name as employee_name',
                                DB::raw("'{$regionalNode['FullHierarchy']} -> {$areaNode['FullHierarchy']} -> {$unitNode['FullHierarchy']}' as fullhierarchy"),
                                'ch.position_id as current_position_id',
                                'p.position_name as current_position',
                                DB::raw("'$unitId' as unit_id"), // Explicitly set unit_id from $allData
                                DB::raw("'$areaId' as area_id"), // Explicitly set area_id from $allData
                                DB::raw("'$regionalId' as regional_id"), // Explicitly set regional_id from $allData
                                'ch.start_date as start_date',
                                'ch.end_date as end_date',
                            ])
                            ->where('p.parent_id', $unitId) // Filter by unit ID
                            ->when($status, function ($query) use ($status) {
                                if ($status === 'active') {
                                    // Filter for active employees (no end_date or end_date >= NOW)
                                    return $query->where(function($query) {
                                        $query->whereNull('ch.end_date')
                                              ->orWhere('ch.end_date', '>=', now());
                                    });
                                } elseif ($status === 'resigned') {
                                    // Filter for resigned employees (end_date < NOW)
                                    return $query->whereNotNull('ch.end_date')
                                                 ->where('ch.end_date', '<', now());
                                }
                                // If 'both', we don't add a filter for active/inactive
                                return $query;
                            })
                            ->get();

                        // Count total employees in the unit
                        $totalEmployeeUnit = $careerData->count();

                        // Add active employees to the area's total
                        $totalEmployeeArea += $totalEmployeeUnit;
    
                        // Add career data to the reports
                        // $reports[] = [
                        //     'Regional' => $regionalName,
                        //     'Area' => $areaName,
                        //     'Unit' => $unitNode['position_name'],
                        //     'Total_Employee_Unit' => $totalEmployeeUnit,
                        //     'Careers' => $careerData,
                        // ];
                        // Add unit data to the area
                        $areaReports[] = [
                            'Unit' => $unitName,
                            'total_employees' => $totalEmployeeUnit,
                            'Careers' => $careerData,
                        ];
                    }

                    // Add active employees to the regional's total
                    $totalEmployeeRegional += $totalEmployeeArea;

                    // Add area data to the regional
                    $regionalReports[] = [
                        'Area' => $areaName,
                        'total_employees' => $totalEmployeeArea, // Total active employees in the area
                        'Units' => $areaReports, // All units under the area
                    ];
                }

                 // Add regional data to the reports
                $reports[] = [
                    'Regional' => $regionalName,
                    'total_employees' => $totalEmployeeRegional, // Total active employees in the regional
                    'Areas' => $regionalReports, // All areas under the regional
                ];
            }

            // dd($reports);
            // dd($reports[2]['Careers']);


            return response()->json([
                'status' => true,
                'message' => 'Data retrieved career reports successfully.',
                'result' => $reports
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data career reports.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function get_employee_joined_by_year()
    {
        try {
            $employeeStats = DB::table('career_histories')
                ->selectRaw('YEAR(start_date) AS Tahun_Bergabung, COUNT(*) AS Jumlah_Karyawan_Bergabung')
                ->groupByRaw('YEAR(start_date)')
                ->orderBy('Tahun_Bergabung')
                ->get();
            
            return response()->json([
                'status' => true,
                'message' => 'Data retrieved career reports successfully.',
                'result' => $employeeStats
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data career reports.',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    
    public function get_employee_resigned_by_year()
    {
        try {
            $resignationStats = DB::table('career_histories')
                ->selectRaw('YEAR(end_date) AS Tahun_Resign, COUNT(*) AS Jumlah_Karyawan_Resign')
                ->whereNotNull('end_date')
                ->groupByRaw('YEAR(end_date)')
                ->orderBy('Tahun_Resign')
                ->get();

            
            return response()->json([
                'status' => true,
                'message' => 'Data retrieved career reports successfully.',
                'result' => $resignationStats
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data career reports.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function get_employee_tenure_over_one_year()
    {
        try {

            $employeeStats = DB::table('career_histories')
            ->selectRaw('COUNT(*) AS Jumlah_Karyawan_Masa_Kerja_lebih_1_Tahun')
            ->whereRaw('DATEDIFF(IFNULL(end_date, NOW()), start_date) > 365') // If end_date is NULL, use current date (NOW())
            ->get();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved career reports successfully.',
                'result' => $employeeStats
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data career reports.',
                'error' => $e->getMessage()
            ], 500);
        }

    }
    
    public function get_unit_heads_with_ao_experience(Request $request)
    {
        try {
            // Get position names from the request (default to specific positions if not provided)
            // Get positions from request, or set default values
            $position1 = $request->input('position1', 'Kepala Unit');
            $position2 = $request->input('position2', 'Account Officer');


            // Query to find employees who held both positions
            $result = DB::table('career_histories as ch1')
                ->join('employees as e', 'ch1.emp_id', '=', 'e.emp_id')
                ->join('career_histories as ch2', 'ch1.emp_id', '=', 'ch2.emp_id')
                ->join('positions as p1', 'ch1.position_id', '=', 'p1.position_id')
                ->join('positions as p2', 'ch2.position_id', '=', 'p2.position_id')
                ->select('e.emp_id', 'e.emp_name')
                ->where('p1.position_name', $position1)
                ->where('p2.position_name', $position2)
                ->distinct()
                ->get();

            $jumlahKaryawan = $result->count(); // Count unique employees
    
            return response()->json([
                'status' => true,
                'message' => "Jumlah $position1 yang pernah menjabat sebagai $position2 retrieved successfully.",
                'Jumlah_Karyawan' => $jumlahKaryawan,
                'Details' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
