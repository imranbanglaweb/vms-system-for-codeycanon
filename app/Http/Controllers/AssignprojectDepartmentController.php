<?php

namespace App\Http\Controllers;

use App\Models\AssignprojectDepartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Atglance;
use App\Models\Unit;
use App\Models\Department;
use App\Models\Location;
use App\Models\Employee;
use App\Models\User;
use App\Models\SupportType;
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
class AssignprojectDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // dd('sdsd');
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


          // $unit_id =implode(',', $request->unit_id);
          $location_id =implode(',', $request->location_id);
          $department_id =implode(',', $request->department_id);


            $count  = DB::table('assignproject_departments')
                    ->where('unit_id',$request->unit_id)
                    ->count(); 
   // dd($count);
// dd($department_id);
    if ($count >0) {

        $updateDetails = [
            'unit_id' => $request->unit_id,
            'project_location_id' => $location_id,
            'department_id' => $department_id
        ];

                    DB::table('assignproject_departments')
                ->where('unit_id', $request->unit_id)
                ->update($updateDetails);
        
    }
    else{
            $assignproject_departments = new AssignprojectDepartment();
            $assignproject_departments->unit_id     = $request->unit_id;
            $assignproject_departments->project_location_id     = $location_id;
            $assignproject_departments->department_id     = $department_id;
            $assignproject_departments->created_by    = Auth::id();
            $assignproject_departments->save();
    }





    }
//     public function store(Request $request)
//     {
//           $validator = Validator::make($request->all(), [
//                     "unit_id" => "required",
//         ]);
//           $unit_id = $request->unit_id;
//           $project_location_id = $request->location_id;
//           $department_id = $request->department_id;

//    // dd($department_id);

// foreach($request['department_id'] as $val){

//             $assignproject_departments = new AssignprojectDepartment();
//             $assignproject_departments->unit_id     = $request->unit_id;
//             $assignproject_departments->project_location_id     = $request->location_id;
//             $assignproject_departments->department_id     = $val;
//             $assignproject_departments->created_by    = Auth::id();
//             $assignproject_departments->save();
// }

//     }



public function unit_wise_location_assigned(Request $request){

   if ($request->location_id) {

//               $location_id =implode(',', $request->location_id);
// // dd($department_id);
//               $location_ids  = json_decode($location_id, true);
//               $location_ids =  array_map('intval', explode(',', $location_id));

     // $data['department_exits'] = DB::table('assignemployees')
     //            ->where('employee_id',$request->employee_id)
     //            ->where('department_id',$request->department_id)
     //            ->count();

     $data['location_list_add'] = DB::table('locations')
                ->where('id',$request->location_id)
                ->get();

    }
echo json_encode($data);

}


public function location_wise_department_list(Request $request){

   if ($request->location_id) {

//               $location_id =implode(',', $request->location_id);
// dd($department_id);
//               $location_ids  = json_decode($location_id, true);
//               $location_ids =  array_map('intval', explode(',', $location_id));

     // $data['department_exits'] = DB::table('assignemployees')
     //            ->where('employee_id',$request->employee_id)
     //            ->where('department_id',$request->department_id)
     //            ->count();

     $department_id = DB::table('assignproject_departments')
                ->where('project_location_id',$request->location_id)
                ->pluck('department_id');

      // $data['department_list'] = DB::table('departments')
      //           ->whereIn('id',[$department_id])
      //           ->get();

   $department_id = str_replace('', '', $department_id[0]);
    $department_list  = json_decode($department_id, true);
    $department_list =  array_map('intval', explode(',', $department_id));

$user_type_department_head = DB::table('users')->select('user_type','id')
->where('id',Auth::id())
->where('user_type','department_head')
->first();

$user_type_admin = DB::table('users')->select('user_type','id')
->where('id',Auth::id())
->where('user_type','admin')
->first();



if(!empty($user_type_admin)){
// dd($department_id);
      $data['department_list'] = DB::table('departments')
                ->whereIn('id',$department_list)
                ->get();
}
    else if (!empty($user_type_department_head)) {
      $data['department_list'] = DB::table('departments')
                ->whereIn('id',$department_list)
                  ->where('id',Auth::user()->department_id)
                ->get();
}



else{

      $data['department_list'] = DB::table('departments')
                ->whereIn('id',$department_list)
                ->where('id',Auth::user()->department_id)
                ->get();
}

        



    }
echo json_encode($data);

}

    public  function assign_project_department(Request $request){

          $units            = Unit::get();
          $department_lists = Department::get();
          $location_lists   = Location::get();
          $employee_lists   = Employee::orderBy('employee_oder','ASC')->get();
    $user_lists           = User::orderBy('id','ASC')->whereNotIn('user_name',['admin'])->get();
          $categories       = Category::orderBy('id','ASC')->get();
          $support_type_lists = SupportType::get();

       return view('admin.dashboard.assign_project_department',compact('units','department_lists'));

    }
 public function unit_already_assigned(Request $request){
      



    $data['unit_exits'] = DB::table('assignproject_departments')
    ->where('unit_id',$request->unit_id)
    ->count(); 


if ($data['unit_exits'] > 0) {



// dd($unit_list);
    $location_list_by_unit = DB::table('assignproject_departments')
                ->where('unit_id',$request->unit_id)
                ->pluck('project_location_id'); 

    $location_id = str_replace('', '', $location_list_by_unit[0]);
    $location_list  = json_decode($location_list_by_unit, true);
    $location_list =  array_map('intval', explode(',', $location_id));




     $data['assigned_location_list'] = DB::table('locations')
                ->whereIn('id',$location_list)
                ->get();


     $data['location_list'] = DB::table('locations')
                ->where('unit_id',$request->unit_id)
                ->whereNotIn('id',$location_list)
                ->get();
                

   $department_list_by_unit = DB::table('assignproject_departments')
            ->where('unit_id',$request->unit_id)
            ->pluck('department_id'); 

    $department_id = str_replace('', '', $department_list_by_unit[0]);
    $department_list  = json_decode($department_list_by_unit, true);
    $department_list =  array_map('intval', explode(',', $department_id));



     $data['department_list'] = DB::table('departments')
                ->whereIn('id',$department_list)
                ->get();

     $data['department_list_add'] = DB::table('departments')
                ->whereIn('id',$department_list)
                ->get();

     $data['department_list_exits'] = DB::table('departments')
                ->whereNotIn('id',$department_list)
                ->get();


   if ($request->department_id) {

     $data['department_exits'] = DB::table('assignemployees')
                ->where('department_id',$request->department_id)
                ->get();
    }




}
else{

    // dd('no exists');
            $data['location_list'] = DB::table('locations')
                ->where('unit_id',$request->unit_id)
                ->get();

            $data['assigned_location_list'] = DB::table('locations')
                ->where('unit_id',$request->unit_id)
                ->get();

         $data['department_list'] = DB::table('departments')->get();


}


echo json_encode($data);


    }


    public function unit_wise_department_assigned(Request $request){


   if ($request->department_id) {

              $department_id =implode(',', $request->department_id);
// dd($department_id);
              $department_ids  = json_decode($department_id, true);
              $department_ids =  array_map('intval', explode(',', $department_id));

     // $data['department_exits'] = DB::table('assignemployees')
     //            ->where('employee_id',$request->employee_id)
     //            ->where('department_id',$request->department_id)
     //            ->count();

     $data['department_list_add'] = DB::table('departments')
                ->whereIn('id',$department_ids)
                ->get();

    }
echo json_encode($data);

    }

public function assignproject_department_already_assigned(Request $request){
      

        // return dd($request->department_id);

  $data = DB::table('assignproject_departments')
                ->where('unit_id',$request->unit_id)
                ->where('project_location_id',$request->location_id)
                ->whereIn('department_id',$request->department_id)
                ->count(); 

        echo json_encode($data);

    }


}
