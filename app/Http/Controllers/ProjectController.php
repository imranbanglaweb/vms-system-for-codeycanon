<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Unit;
use App\Models\Company;
use App\Models\Department;
use App\Models\Location;
use App\Models\Project;
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


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            // $departments = Department::orderBy('id','ASC')->get();
            $project_lists = DB::table('projects')
                        ->select('projects.id as p_id','projects.project_name','projects.project_description','companies.company_name','units.unit_name')
                        ->leftJoin('units','projects.unit_id','=','units.id')
                        ->leftJoin('companies','projects.company_id','=','companies.id')
                        ->get();
        return view('admin.dashboard.project.index',compact('project_lists'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $units = Unit::get();
         $companies = Company::get();
        return view('admin.dashboard.project.create',compact('companies','units'));
    }

    public function projectItCreate()
    {

        return view('admin.dashboard.project.itproject');
    }


    public function unit_wise_company(Request $request){
      
      $unit_id      = $request->unit_id;

        $data['company_list'] = DB::table('companies')
                            // ->select('moujas.id as ID', 'moujas.mouja_name','projects.id')
                            ->where('unit_id',$unit_id)
                            ->get();    
        echo json_encode($data);

    }
    public function store(Request $request)
    {

          $validator = Validator::make($request->all(), [
                    // "unit_id" => "required",
                    "project_name" => "required",
        ]);


// return dd($request);

        // if ($validator->fails()) {
        //       return redirect()->back()->withErrors($validator->errors());
        //     // return response()->json(['errors' => $validator->errors()->all()], 400);
        // }

           if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

// return dd($request);


           if (!empty($request->unit_id)) {
                $projects = Project::updateOrCreate(

        ['id'   => $request->id],
        [
        'unit_id'             => $request->unit_id,
        'company_id'          => $request->company_id,
        'department_id'       => $request->department_id,
        'location_id'         => $request->location_id,
        'project_name'        => $request->project_name,
        'starting_date'        => $request->starting_date,
        'ending_date'        => $request->ending_date,
        'project_type'        => $request->project_type,
        'project_deadline'        => $request->project_deadline,
        'project_location'        => $request->project_location,
        'project_status'        => $request->project_status,
        'project_description' => $request->project_description,
        'project_oder'        => 1,
        'remarks'             => $request->remarks,
        'created_by'          => Auth::id(),
        ],
     
        );
        
        }
        else{
               $projects = Project::updateOrCreate(

        ['id'   => $request->id],
        [
        'unit_id'             => $request->unit_id,
        'company_id'          => $request->company_id,
        'department_id'       => $request->department_id,
        'location_id'         => $request->location_id,
        'project_name'        => $request->project_name,
        'starting_date'        => $request->starting_date,
        'ending_date'        => $request->ending_date,
        'project_type'        => $request->project_type,
        'project_deadline'        => $request->project_deadline,
        'project_location'        => $request->project_location,
        'project_status'        => $request->project_status,
        'project_description' => $request->project_description,
        'project_oder'        => 1,
        'remarks'             => $request->remarks,
        'created_by'          => Auth::id(),
        ],
     
        );
        }

        // $setting->path = '/storage/'.$path;
        return response()->json('Project Added Successfully');
    }



    public function assignproject(Request $request)
    {
                   $user_lists = User::get();
          $projects = Project::get();
        return view('admin.dashboard.project.assignproject',compact('projects','user_lists'));
    }


    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $units = Unit::get();
         $departments = Department::get();
         $locations   = Location::get();
         $companies   = Company::get();
         $project_edit = Project::find($id);

         // return dd($companies);

        return view('admin.dashboard.project.edit',compact('project_edit','units','companies','departments','locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                       Project::find($id)->delete();
        return redirect()->route('projects.index')
                        ->with('danger','Project Deleted successfully');
    }


}
