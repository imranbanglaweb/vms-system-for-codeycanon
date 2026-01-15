<?php

namespace App\Http\Controllers;

use App\Models\Assignemployee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Atglance;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use \DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use App\Exports\ExportLandinventory;
Use \Carbon\Carbon;
Use Redirect;
Use Session;

class AssignemployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
                    "unit_id" => "required",
        ]);
          $employee_id = $request->employee_id;
          $unit_id =implode(',', $request->unit_id);
          $location_id =implode(',', $request->location_id);
          $department_id =implode(',', $request->department_id);


            $count  = DB::table('assignemployees')
                ->where('employee_id',$request->employee_id)
                // ->where('unit_id',$request->unit_id)
                // ->where('project_location_id',$request->location_id)
                // ->whereIn('department_id',[$request->department_id])
                // ->where('surveyheaderdatas.sub_emp_id',$request->sub_emp_id)
                ->count(); 
   // dd($count);

    if ($count >0) {

        $updateDetails = [
            'unit_id' => $unit_id,
            'project_location_id' => $location_id,
            'department_id' => $department_id
        ];

                    DB::table('assignemployees')
                ->where('employee_id', $request->get('employee_id'))
                ->update($updateDetails);
        
    }
    else{
                    $assignproject_employee = new Assignemployee();
            $assignproject_employee->employee_id     = $employee_id;
            $assignproject_employee->unit_id     = $unit_id;
            $assignproject_employee->project_location_id     = $location_id;
            $assignproject_employee->department_id     = $department_id;
            $assignproject_employee->created_by    = Auth::id();
            $assignproject_employee->save();
    }





    }

    public function employee_already_assigned(Request $request){
      


  // $count = DB::table('assignemployees')
  //               ->where('employee_id',$request->employee_id)
  //               ->count(); 

  $count  = DB::table('assignemployees')
                ->where('employee_id',$request->employee_id)
                ->where('unit_id',$request->unit_id)
                ->where('project_location_id',$request->location_id)
                // ->whereIn('department_id',[$request->department_id])
                // ->where('surveyheaderdatas.sub_emp_id',$request->sub_emp_id)
                ->count(); 


  $department_list_by_employee  = DB::table('assignemployees')
                ->where('employee_id',$request->employee_id)
                ->where('unit_id',$request->unit_id)
                ->where('project_location_id',$request->location_id)
                // ->whereIn('department_id',[$request->department_id])
                // ->where('surveyheaderdatas.sub_emp_id',$request->sub_emp_id)
                ->pluck('department_id'); 
  // $department_list_by_employee =  $department_list_by_employee->department_id;
          // $department_id =implode(',', $department_list_by_employee);

        // return dd($count);



if ($count >0 ) {
    $department_id = str_replace('', '', $department_list_by_employee[0]);
    $department_list_by_employee  = json_decode($department_list_by_employee, true);
    $department_list_by_employee =  array_map('intval', explode(',', $department_id));
     $data['department_list'] = DB::table('departments')
                ->whereIn('id',$department_list_by_employee)
                ->get();



        // $data['department_list_add'] = DB::table('departments')
        //         ->whereNotIn('id',$department_list_by_employee)
        //         ->get();
}
else{
    $data['department_list'] = "";
            // $data['department_list_add'] = DB::table('departments')
            //     // ->whereNotIn('id',$department_list_by_employee)
            //     ->get();
}

    $data['employee_exits'] = DB::table('assignemployees')
    ->where('employee_id',$request->emp_id)
    ->count(); 


if ($data['employee_exits'] > 0) {

         $unit_list_by_employee = DB::table('assignemployees')
                ->where('employee_id',$request->emp_id)
                ->pluck('unit_id'); 


    $unit_id = str_replace('', '', $unit_list_by_employee[0]);
    $unit_list  = json_decode($unit_list_by_employee, true);
    $unit_list =  array_map('intval', explode(',', $unit_id));

// dd($unit_list);
    $location_list_by_employee = DB::table('assignemployees')
                ->where('employee_id',$request->emp_id)
                ->pluck('project_location_id'); 

    $location_id = str_replace('', '', $location_list_by_employee[0]);
    $location_list  = json_decode($location_list_by_employee, true);
    $location_list =  array_map('intval', explode(',', $location_id));

   $department_list_by_employee = DB::table('assignemployees')
            ->where('employee_id',$request->emp_id)
            ->pluck('department_id'); 

    $department_id = str_replace('', '', $department_list_by_employee[0]);
    $department_list  = json_decode($department_list_by_employee, true);
    $department_list =  array_map('intval', explode(',', $department_id));

     $data['unit_list'] = DB::table('units')
                ->whereIn('id',$unit_list)
                ->get();

     $data['department_list'] = DB::table('departments')
                ->whereIn('id',$department_list)
                ->get();

     $data['department_list_add'] = DB::table('departments')
                ->whereNotIn('id',$department_list)
                ->get();

     $data['department_list_exits'] = DB::table('departments')
                ->whereNotIn('id',$department_list)
                ->get();

     $data['location_list'] = DB::table('locations')
                ->whereIn('id',$location_list)
                ->get();

   if ($request->department_id) {

     $data['department_exits'] = DB::table('assignemployees')
                ->where('department_id',$request->department_id)
                ->get();
    }




}
else{

    // dd('no exists');
       $data['department_list_add'] = DB::table('departments')
                // ->whereNotIn('id',$department_list)
                ->get();
        $data['unit_list'] = DB::table('units')
                ->get();
         $data['location_list'] = DB::table('locations')
                ->get();
}


   if ($request->department_id) {

              // $department_id =implode(',', $request->department_id);
// dd($department_id);
              // $department_ids  = json_decode($department_id, true);
              // $department_ids =  array_map('intval', explode(',', $department_id));

     // $data['department_exits'] = DB::table('assignemployees')
     //            ->where('employee_id',$request->employee_id)
     //            ->where('department_id',$request->department_id)
     //            ->count();

     $data['department_list_add'] = DB::table('departments')
                ->where('id',$request->department_id)
                ->get();

    }
echo json_encode($data);


    }


public function add_department_to_location(Request $request){

    if ($request->department_id) {

    // return dd($request->department_id);
     $data['department_list_add'] = DB::table('departments')
                ->where('id',$request->department_id)
                ->get();
}
        echo json_encode($data);
}

    public function show(Assignemployee $assignemployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignemployee  $assignemployee
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignemployee $assignemployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignemployee  $assignemployee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignemployee $assignemployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignemployee  $assignemployee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignemployee $assignemployee)
    {
        //
    }
}
