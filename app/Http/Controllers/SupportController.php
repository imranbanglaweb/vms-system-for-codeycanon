<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Models\Supportdetail;
use App\Models\Assigntask;
use App\Models\User;
use App\Models\IssueRegister;
use App\Models\SupportType;
use App\Models\Category;
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
use App\Exports\SampleImportFormatExport;
Use \Carbon\Carbon;
Use Redirect;
Use Session;
use App\Models\Employee;
Use Mail;
use Illuminate\Support\Str;
// use DataTables;
use App\Imports\TaskImport;
class SupportController extends Controller
{
   


   public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

            // $departments = Department::orderBy('id','ASC')->get();
            // $project_lists = DB::table('projects')
            //             ->select('projects.id as p_id','projects.project_name','projects.project_description','companies.company_name','units.unit_name')
            //             ->leftJoin('units','projects.unit_id','=','units.id')
            //             ->leftJoin('companies','projects.company_id','=','companies.id')
            //             ->get();


      $location_lists = DB::table('locations')
                          ->where('id',Auth::user()->location_id)
                          ->get();
      $department_lists = DB::table('departments')->get();

    //   $location_assigned = DB::table('locations')
    // ->whereIn('id',$location_list_by_employee)
    // ->get();

    //   $department_assigned = DB::table('departments')
    // ->whereIn('id',$department_list_by_employee)
    // ->get();
     $categories = Category::orderBy('id','desc')
                        ->where('department_id',Auth::user()->department_id)
                        ->get();

      $user_type_admin = DB::table('users')->select('user_type','id')
      ->where('id',Auth::id())
      ->where('user_type','admin')
      ->first();

      $user_type_department_head = DB::table('users')->select('user_type','id')
      ->where('id',Auth::id())
      ->where('user_type','department_head')
      ->first();


// return dd($user_type_admin->user_type);

  if ($request->ajax()) {


    if (!empty($user_type_admin)) {

        $data = IssueRegister::select(
               [
                'issue_registers.task_id',
                'issue_registers.id',
                 'issue_registers.category_id',
                 'issue_registers.issue_date',
                 'issue_registers.raised_by',
                 'issue_registers.title',
                 'issue_registers.quantity',
                 'issue_registers.issue_type_id',
                 'issue_registers.issue_come_from',
                 'issue_registers.issue_status',
                 'issue_registers.created_by',
                 'issue_registers.assigned_to',
                 'issue_registers.department_id',
                 'issue_registers.remarks',
                 'issue_registers.assign_task_status',
                  'issue_registers.assigned_employee_status',
                 'issue_registers.support_id',
                  'issue_registers.task_start_date',
                  'issue_registers.task_completed_date',
                 'issue_registers.task_due_date',
                ]
            )
// return dd('yah');
            // ->where('assign_task_status',Auth::id())
            ->orderBy('issue_registers.id','desc')
            ->get();
    }


    else if (!empty($user_type_department_head)) {

  $data = IssueRegister::select(
               [
                'issue_registers.task_id',
                'issue_registers.id',
                 'issue_registers.category_id',
                 'issue_registers.issue_date',
                 'issue_registers.raised_by',
                 'issue_registers.issue_type_id',
                 'issue_registers.title',
                 'issue_registers.quantity',
                 'issue_registers.issue_come_from',
                 'issue_registers.issue_status',
                 'issue_registers.created_by',
                 'issue_registers.assigned_to',
                 'issue_registers.department_id',
                 'issue_registers.remarks',
                 'issue_registers.assign_task_status',
                'issue_registers.assigned_employee_status',
                 'issue_registers.support_id',
                 'issue_registers.task_start_date',
                 'issue_registers.task_completed_date',
                 'issue_registers.task_due_date',
                ]
            )

            ->where('issue_registers.department_id',Auth::user()->department_id)
            ->orderBy('issue_registers.id','desc')
            ->get();

    }

    else{

        $data = IssueRegister::select(
               [
                'issue_registers.task_id',
                'issue_registers.id',
                 'issue_registers.category_id',
                 'issue_registers.issue_date',
                 'issue_registers.raised_by',
                 'issue_registers.issue_type_id',
                 'issue_registers.issue_come_from',
                 'issue_registers.assigned_to',
                 'issue_registers.title',
                  'issue_registers.quantity',
                 'issue_registers.issue_status',
                 'issue_registers.created_by',
                 'issue_registers.department_id',
                 'issue_registers.remarks',
                 'issue_registers.assign_task_status',
                 'issue_registers.assigned_employee_status',
                 'issue_registers.support_id',
                 'issue_registers.task_start_date',
                 'issue_registers.task_completed_date',
                 'issue_registers.task_due_date',
                ]
            )

            ->where('issue_registers.department_id',Auth::user()->department_id)
            ->where('issue_registers.created_by',Auth::id())
            // ->orWhere('issue_registers.assign_task_status',Auth::id())
            ->orderBy('issue_registers.id','desc')
            ->get();
    }
          
            return Datatables::of($data)
                    ->addIndexColumn()
          
               ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('created_by') && $request->get('created_by') !='all')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['created_by'], $request->get('created_by')) ? true : false;
                            });
                        }

                       // else if (!empty($request->get('created_by') =='all')) {
                       //      $instance->collection = $instance->collection->filter(function ($row) use ($request) {

                       //          return Str::contains($row['created_by'], ) ? true : false;
                       //      });
                       //  }

                      

                    })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">Edit</a>';
                    return $btn;
                })
                  ->addColumn('category_name', function (IssueRegister $issue_registers) {
                         return $issue_registers->categoryName->category_name;
                    })

                  ->addColumn('title_name', function (IssueRegister $issue_registers) {
                         return $issue_registers->titleName->task_title;
                    })
                  ->addColumn('employee_name', function (IssueRegister $issue_registers) {
                         return $issue_registers->employeeName->employee_name;
                    })
                ->addColumn('assign_to', function (IssueRegister $issue_registers) {

                    //   if ($issue_registers->assigned_employee_status == 'other') {
                    //      $assign_to = '<a href="javascript:void(0)" disabled title="You Can Not Changed Status" data-id="'.$issue_registers->id.' " class="btn btn-success btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-duotone fa-plus"></i> Already Assign</a>';
                    // return $assign_to;


                    //   }
                    //   else{

                    //       if (($issue_registers->issue_status == 'Completed')) {
                    //          $assign_to = '<a href="javascript:void(0)" disabled data-id="'.$issue_registers->id.' " class="btn btn-success btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-duotone fa-plus"></i> Assign </a>';
                    //             return $assign_to;
                    //       }
                    //       else{

                    //           $assign_to = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " class="btn btn-success btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-duotone fa-plus"></i> Assign</a>';
                    // return $assign_to;
                    //       }

                    //   }

                     if ($issue_registers->assigned_to == Auth::user()->employee_id) {
                          if( $issue_registers->issue_status== 'Completed')
                          {
                     $assign_to = '<a href="javascript:void(0)" disabled  title="You Can Not Changed Status" data-id="'.$issue_registers->id.' " class="btn btn-success btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-duotone fa-plus"></i> Assign</a>';

                         return $assign_to;

                       }
                       else{
                          $assign_to = '<a href="javascript:void(0)"  title="You Can Not Changed Status" data-id="'.$issue_registers->id.' " class="btn btn-success btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-duotone fa-plus"></i> Assign</a>';

                       return $assign_to;
                       }


                      }
                      else{

                   $assign_to = '<a href="javascript:void(0)" disabled title="You Can Not Changed Status" data-id="'.$issue_registers->id.' " class="btn btn-warning btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-duotone fa-plus"></i> Already Assign</a>';
                    return $assign_to;

                    //       if (($issue_registers->issue_status == 'Completed')) {
                    //          $assign_to = '<a href="javascript:void(0)" disabled data-id="'.$issue_registers->id.' " class="btn btn-success btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-duotone fa-plus"></i> Assign </a>';
                    //             return $assign_to;
                    //       }
                    //       else{

                    //           $assign_to = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " disable class="btn btn-success btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-duotone fa-plus"></i> Assign</a>';
                    // return $assign_to;
                    //       }

                      }



                   
                    })

                  ->addColumn('changed_status', function (IssueRegister $issue_registers) {

                          $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " class="btn btn-primary btn-sm changed_status">'.$issue_registers->issue_status.'</a>';


                          if ( $issue_registers->issue_status =='Completed') {

                       $changed_status = '<a href="javascript:void(0)" disabled="disable" alt="You Cam Chaanged Status" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'"  data-support_type_id ="'.$issue_registers->support_id  .'" class="btn btn-success btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }

                            
                          elseif($issue_registers->issue_status == 'Pending'){

                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-warning btn-sm changed_status">'.'<i class="fa fa-lock"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }

                          elseif($issue_registers->issue_status == 'Ongoing'){

                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-primary btn-sm changed_status">'.'<i class="fa fa-spinner fa-spin"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }
                          elseif($issue_registers->issue_status == 'Proceess'){

                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-primary btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }
                          else{

                      
                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-danger btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }

if ($issue_registers->assigned_to == Auth::user()->employee_id) {

 // $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-info  btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';


}

else{

 $changed_status = '<a href="javascript:void(0)" disabled class="btn btn-danger btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

}
                         return $changed_status;
                    })

                  ->editColumn('issue_dates', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->issue_date)->format('d M y'); return $formatedDate; 
                })

                     ->addColumn('view', function (IssueRegister $issue_registers) {
                    // $view = '<a href="'. route('support-details.show', $issue_registers->id).'" class="btn btn-primary btn-sm" data-id="'.$issue_registers->id.' "><i class="fa fa-eye"></i></a>';

     $view = '<a href="javascript:void(0)" title="View" data-id="'.$issue_registers->id.' " class="btn btn-primary btn-sm view_details" data-id="'.$issue_registers->id.' "><i class="fa fa-eye"></i></a>';


                    return $view;
                    })
                   
                  ->addColumn('history', function (IssueRegister $issue_registers) {

                        // $history = '<a href="javascript:void(0)" title="Task History" data-id="'.$issue_registers->id.' " class="btn btn-info btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-history" aria-hidden="true"></i></a>';

               $history = '<a href="'. route('support-details.history', $issue_registers->id).'" class="btn btn-info" data-id="'.$issue_registers->id.' "><i class="fa fa-history aria-hidden="true""></i></a>';

                    return $history;

                      })
                  
                ->rawColumns(['action','changed_status','view','issue_dates','increment_data','assign_to','history','created_by','category_name','title_name'])
                ->make(true);
        }

        return view('admin.dashboard.support.index',
          compact('location_lists','department_lists','categories')
              );

    }


 public function pendingsupport(Request $request)
    {

            // $departments = Department::orderBy('id','ASC')->get();
            // $project_lists = DB::table('projects')
            //             ->select('projects.id as p_id','projects.project_name','projects.project_description','companies.company_name','units.unit_name')
            //             ->leftJoin('units','projects.unit_id','=','units.id')
            //             ->leftJoin('companies','projects.company_id','=','companies.id')
            //             ->get();

 $user_type_admin = DB::table('users')->select('user_type','id')
->where('id',Auth::id())
->where('user_type','admin')
->first();


  if ($request->ajax()) {


      if (!empty($user_type_admin)) {

            $data = IssueRegister::select(
               [
                'issue_registers.task_id',
                'issue_registers.id',
                 'issue_registers.category_id',
                 'issue_registers.issue_date',
                 'issue_registers.raised_by',
                 'issue_registers.issue_type_id',
                 'issue_registers.issue_come_from',
                 'issue_registers.assigned_to',
                 'issue_registers.issue_status',
                 'issue_registers.remarks',
                 'issue_registers.assign_task_status',
                 'issue_registers.support_id',
                ]
            )

            // ->where('assign_task_status',Auth::id())
            // ->where('issue_registers.issue_status','Pending')
            ->where('issue_registers.issue_status','Ongoing','Pending')
            ->orderBy('issue_registers.id','desc')
            ->get();

        }
        else{

            $data = IssueRegister::select(
               [
                'issue_registers.task_id',
                'issue_registers.id',
                 'issue_registers.category_id',
                 'issue_registers.issue_date',
                 'issue_registers.assigned_to',
                 'issue_registers.raised_by',
                 'issue_registers.issue_type_id',
                 'issue_registers.assigned_to',
                 'issue_registers.issue_come_from',
                 'issue_registers.issue_status',
                 'issue_registers.remarks',
                 'issue_registers.assign_task_status',
                 'issue_registers.support_id',
                ]
            )

            // ->where('issue_registers.assign_task_status',Auth::id())
            // // ->where('issue_registers.issue_status','Pending')
            // ->where('issue_registers.issue_status','Ongoing','Pending')
            // ->orderBy('issue_registers.id','desc')
            // ->get();

             ->where('issue_registers.department_id',Auth::user()->department_id)
            ->where('issue_registers.created_by',Auth::id())
               ->where('issue_registers.issue_status','Ongoing','Pending')
            ->orWhere('issue_registers.assign_task_status',Auth::id())
            ->orderBy('issue_registers.id','desc')
            ->get();
        }

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">Edit</a>';
                    return $btn;
                })
                  ->addColumn('category_name', function (IssueRegister $issue_registers) {
                         return $issue_registers->categoryName->category_name;
                    })
                  ->addColumn('employee_name', function (IssueRegister $issue_registers) {
                         return $issue_registers->employeeName->employee_name;
                    })
              
                  ->addColumn('changed_status', function (IssueRegister $issue_registers) {

                          $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " class="btn btn-primary btn-sm changed_status">'.$issue_registers->issue_status.'</a>';

                          if ( $issue_registers->issue_status== 'Completed') {

                       $changed_status = '<a href="javascript:void(0)" disabled="disable" alt="You Cam Chaanged Status" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'"  data-support_type_id ="'.$issue_registers->support_id  .'" class="btn btn-success btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';


                          }

                          elseif($issue_registers->issue_status == 'Pending'){

                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-warning btn-sm changed_status">'.'<i class="fa fa-lock"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }
                          elseif($issue_registers->issue_status == 'Ongoing'){

                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-primary btn-sm changed_status">'.'<i class="fa fa-spinner fa-spin"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }
                          elseif($issue_registers->issue_status == 'Proceess'){

                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-primary btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }
                          else{

                      
                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-danger btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }
                         return $changed_status;
                    })

                  ->editColumn('issue_dates', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->issue_date)->format('d M y'); return $formatedDate; 
                })

                     ->addColumn('view', function (IssueRegister $issue_registers) {
                    $view = '<a href="'. route('support-details.show', $issue_registers->id).'" class="btn btn-primary btn-sm" data-id="'.$issue_registers->id.' "><i class="fa fa-eye"></i></a>';
                    return $view;
                    })
                     ->addColumn('assign_to', function (IssueRegister $issue_registers) {
                    $assign_to = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " class="btn btn-success btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-duotone fa-plus"></i> Assign Task</a>';
                    return $assign_to;
                    })
                  
                ->rawColumns(['action','changed_status','view','issue_dates','increment_data','assign_to'])
                ->make(true);
        }

        return view('admin.dashboard.support.pendingsupports');

    }


    public function emergencytask(Request $request)
    {

            // $departments = Department::orderBy('id','ASC')->get();
            // $project_lists = DB::table('projects')
            //             ->select('projects.id as p_id','projects.project_name','projects.project_description','companies.company_name','units.unit_name')
            //             ->leftJoin('units','projects.unit_id','=','units.id')
            //             ->leftJoin('companies','projects.company_id','=','companies.id')
            //             ->get();

 

  if ($request->ajax()) {

     $user_type_admin = DB::table('users')->select('user_type','id')
->where('id',Auth::id())
->where('user_type','admin')
->first();

 if (!empty($user_type_admin)) {

            $data = IssueRegister::select(
               [
                'issue_registers.task_id',
                'issue_registers.id',
                 'issue_registers.category_id',
                 'issue_registers.issue_date',
                 'issue_registers.raised_by',
                 'issue_registers.issue_type_id',
                 'issue_registers.issue_come_from',
                 'issue_registers.issue_status',
                 'issue_registers.remarks',
                 'issue_registers.assign_task_status',
                 'issue_registers.support_id',
                ]
            )

            ->where('issue_registers.issue_type_id','Emergency')
            ->orderBy('issue_registers.id','desc')
            ->get();

          }

          else{
             $data = IssueRegister::select(
               [
                'issue_registers.task_id',
                'issue_registers.id',
                 'issue_registers.category_id',
                 'issue_registers.issue_date',
                 'issue_registers.raised_by',
                 'issue_registers.issue_type_id',
                 'issue_registers.issue_come_from',
                 'issue_registers.issue_status',
                 'issue_registers.remarks',
                 'issue_registers.assign_task_status',
                 'issue_registers.support_id',
                ]
            )

            ->where('assign_task_status',Auth::id())
            ->where('issue_registers.issue_type_id','Emergency')
            ->orderBy('issue_registers.id','desc')
            ->get();

          }

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">Edit</a>';
                    return $btn;
                })
                  ->addColumn('category_name', function (IssueRegister $issue_registers) {
                         return $issue_registers->categoryName->category_name;
                    })
                  ->addColumn('employee_name', function (IssueRegister $issue_registers) {
                         return $issue_registers->employeeName->employee_name;
                    })
              
                  ->addColumn('changed_status', function (IssueRegister $issue_registers) {

                          $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " class="btn btn-primary btn-sm changed_status">'.$issue_registers->issue_status.'</a>';

                          if ( $issue_registers->issue_status== 'Completed') {

                       $changed_status = '<a href="javascript:void(0)" disabled="disable" alt="You Cam Chaanged Status" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'"  data-support_type_id ="'.$issue_registers->support_id  .'" class="btn btn-success btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';


                          }

                          elseif($issue_registers->issue_status == 'Pending'){

                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-warning btn-sm changed_status">'.'<i class="fa fa-lock"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }
                          elseif($issue_registers->issue_status == 'Ongoing'){

                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-primary btn-sm changed_status">'.'<i class="fa fa-spinner fa-spin"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }
                          elseif($issue_registers->issue_status == 'Proceess'){

                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-primary btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }
                          else{

                      
                      $changed_status = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " data-category_id="'.$issue_registers->category_id.' "  data-issue_status="'.$issue_registers->issue_status.' "  data-issue_come_from="'.$issue_registers->issue_come_from.' " data-remarks="'.$issue_registers->remarks.'"  data-issue_type_id ="'.$issue_registers->issue_type_id .'"  data-solved_process_id ="'.$issue_registers->solved_process_id  .'" data-assign_task_status ="'.$issue_registers->assign_task_status  .'" data-support_type_id ="'.$issue_registers->support_id  .'"  class="btn btn-danger btn-sm changed_status">'.'<i class="fa fa-check"></i>' .'&nbsp;'.$issue_registers->issue_status.'</a>';

                          }
                         return $changed_status;
                    })

                  ->editColumn('issue_dates', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->issue_date)->format('d M y'); return $formatedDate; 
                })

                     ->addColumn('view', function (IssueRegister $issue_registers) {
                    $view = '<a href="'. route('support-details.show', $issue_registers->id).'" class="btn btn-primary btn-sm" data-id="'.$issue_registers->id.' "><i class="fa fa-eye"></i></a>';
                    return $view;
                    })
                     ->addColumn('assign_to', function (IssueRegister $issue_registers) {


                    $assign_to = '<a href="javascript:void(0)" data-id="'.$issue_registers->id.' " class="btn btn-success btn-sm assign_task" data-id="'.$issue_registers->id.' "><i class="fa fa-duotone fa-plus"></i> Assign Task</a>';
                    return $assign_to;

                    })
                  
                ->rawColumns(['action','changed_status','view','issue_dates','increment_data','assign_to'])
                ->make(true);


        }

        return view('admin.dashboard.support.emergencytask');

    }



    public function create()
    {
         $units = Unit::get();
         $companies = Company::get();
         $employee_lists = Employee::orderBy('employee_oder','ASC')
        ->where('department_id',Auth::user()->department_id)
         ->get();

         // return dd($employee_lists);
         $user_lists = User::orderBy('id','ASC')
         ->whereNotIn('user_name',['admin'])
         ->where('department_id',Auth::user()->department_id)
         ->get();
          $categories = Category::orderBy('id','desc')
                        ->where('department_id',Auth::user()->department_id)
                        ->get();
          $support_type_lists = SupportType::orderBy('id','DESC')->get();
        return view('admin.dashboard.support.create',compact('employee_lists','companies','units','support_type_lists','categories','user_lists'));

    }

    public function unit_wise_employee(Request $request){
      
      $employee_id      = $request->employee_id;

        $data['employee_info'] = DB::table('employees')
                            // ->select('moujas.id as ID', 'moujas.mouja_name','projects.id')
                    ->select(
                            'employees.id as e_id',
                            'employees.unit_id',
                            'employees.department_id',
                            'employees.company_id',
                            'employees.location_id',
                            'companies.company_name',
                            'units.unit_name',
                            'units.id',
                            'departments.department_name',
                            'locations.location_name'
                            )
                        ->leftJoin('units','employees.unit_id','=','units.id')
                        ->leftJoin('companies','employees.company_id','=','companies.id')
                        ->leftJoin('departments','employees.department_id','=','departments.id')
                        ->leftJoin('locations','employees.location_id','=','locations.id')
                            ->where('employees.id',$employee_id)
                            ->get();    
        echo json_encode($data);

    }



    public function category_task_title_show(Request $request){
      
      $category_id      = $request->category_id;

        $data['task_title_data'] = DB::table('tasktitles')
                            ->where('category_id',$category_id)
                            ->get();    
        echo json_encode($data);

    }
    public function user_list_task_info(Request $request){
      


            $data['user_list'] = User::orderBy('id','ASC')
            ->whereNotIn('user_name',['admin'])
            ->where('department_id',Auth::user()->department_id)
            ->get();
        echo json_encode($data);

    }


    public function store(Request $request)
    {

          $validator = Validator::make($request->all(), [
                    "category_id" => "required",
                    "title" => "required",
                    // "issue_date" => "required",
                    // "raised_by" => "required",
                    // "employee_id" => "required",
                    // "unit_id" => "required",
                    // "company_id" => "required",
                    // "department_id" => "required",
                    // "location_id" => "required",
                    // "issue_come_from" => "required",
                    // "support_id" => "required",
        ]);


// return dd($request);

        // if ($validator->fails()) {
        //       return redirect()->back()->withErrors($validator->errors());
        //     // return response()->json(['errors' => $validator->errors()->all()], 400);
        // }

$date = Carbon::now();

$t_id    = DB::table('issue_registers')->select('id')->orderBy('id','desc')->first();
 if (!empty($t_id)) {
 
 $t_id    = $t_id->id;

$t_id    = $t_id + 1;
// return dd($t_id );
$task_id = "#".$date->format('y-m-d') . "-" . str_pad($t_id , 3, "0", STR_PAD_LEFT);

 }

 else{
  $t_id    = 0;

$t_id    = $t_id + 1;
// return dd($t_id );
$task_id = "#".$date->format('y-m-d') . "-" . str_pad($t_id , 3, "0", STR_PAD_LEFT);
 }
// $task_id ='#'.time().Str::random(3);


           if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

// return dd($request);
$employee_email  = DB::table('employees')->where('id',$request->employee_id)->first();


           if (!empty($request->category_id)) {

     

                $issue_register = IssueRegister::updateOrCreate(

        ['id'   => $request->id],
        [
        'task_id'             => $task_id,
        'category_id'         => $request->category_id,
        'issue_date'          => $date->format('y-m-d'),
        'raised_by'           => $request->raised_by,
        'assigned_to'         => $request->assigned_to,
        'employee_id'         => $request->employee_id,
        'unit_id'             => Auth::user()->unit_id,
        'company_id'          => $request->company_id,
        'department_id'       => Auth::user()->department_id,
        'location_id'         => Auth::user()->location_id,
        'project_name'        => $request->project_name,
        'title'               => $request->title,
        'issue_come_from'     => $request->employee_id,
        'support_id'          => $request->support_type_id,
        'issue_type_id'       => $request->issue_type_id,
        'task_details'        => $request->task_details,
        'solved_process_id'   => $request->solved_process_name,
        'issue_status'        => $request->issue_status,
        'task_completed_date' => !empty($request->issue_status == 'Completed') ? Carbon::now() : null ,
        'assign_task_status'  => Auth::id(),
        'status_changed_by'   => Auth::id(),
        'changed_date'        => Carbon::now(),
        'remarks '            => $request->remarks,
        'project_oder'        => 1,
        'remarks'             => $request->remarks,
        'task_start_date'     => $request->task_start_date,
        'task_due_date'       => $request->task_due_date,
        'status'              => $request->status,
        'created_by'          => Auth::id(),
        ],
     
        );

                        // details table entry

                $issue_status = Supportdetail::updateOrCreate(

        ['id'   => $request->id],
        [
        'support_id'          => $issue_register->id,
        'category_id'         => $request->category_id,
        'employee_id'         => $request->assigned_to,
        'issue_type_id'       => $request->issue_type_id,
        'assigned_id'         => $request->assigned_to,
        'support_status'      => $request->issue_status,
        'support_type_id'     => $request->support_type_id,
        'status_changed_by'   => Auth::id(),
        'changed_date'        => Carbon::now(),
        'oder'                => 1,
        'remarks'             => $request->remarks,
        'created_by'          => Auth::id(),
        ],
     
        );
        
        }
        else{
               $issue_register = IssueRegister::updateOrCreate(

                ['id'   => $request->id],
              [
                  'task_id'             => $task_id,
                  'category_id'         => $request->category_id,
                  'issue_date'          => $date->format('y-m-d'),
                  'raised_by'           => $request->raised_by,
                  'assigned_to'         => $request->assigned_to,
                  'employee_id'         => $request->employee_id,
                  'unit_id'             => $request->unit_id,
                  'company_id'          => $request->company_id,
                  'department_id'       => $request->department_id,
                  'location_id'         => $request->location_id,
                  'project_name'        => $request->project_name,
                  'issue_come_from'     => $request->employee_id,
                  'support_id'          => $request->support_type_id,
                  'issue_type_id'       => $request->issue_type_id,
                  'task_details'        => $request->task_details,
                  'solved_process_id'   => $request->solved_process_name,
                  'issue_status'        => $request->issue_status,
     'task_completed_date' => !empty($request->issue_status == 'Completed') ? $date->format('y-m-d') : null,
                  'assign_task_status'  => Auth::id(),
                  'status_changed_by'   => Auth::id(),
                  'changed_date'        => Carbon::now(),
                  'remarks '            => $request->remarks,
                  'project_oder'        => 1,
                  'remarks'             => $request->remarks,
                  'status'              => $request->status,
                  'created_by'          => Auth::id(),
                ],
             
                );
                       // details table entry

                $issue_status = Supportdetail::updateOrCreate(

        ['id'   => $request->id],
        [
        'support_id'          => $issue_register->id,
        'category_id'         => $request->category_id,
        'employee_id'         => $request->employee_id,
        'issue_type_id'       => $request->issue_type_id,
        'assigned_id'         => $request->assigned_to,
        'support_status'      => $request->issue_status,
        'support_type_id'     => $request->support_type_id,
        'status_changed_by'   => Auth::id(),
        'changed_date'        => Carbon::now(),
        'oder'                => 1,
        'remarks'             => $request->remarks,
        'created_by'          => Auth::id(),
        ],
     
        );
        }


        
        $to_email = 'imran@uniquegroupbd.com';

$task_details = DB::table('issue_registers')
                  ->select('employees.employee_name','employees.employee_id as emp_id','employees.designation','employees.employee_email','units.unit_name','departments.department_name','departments.id as Did','users.name','issue_registers.*','supportdetails.remarks as Remarks','supportdetails.support_status')
              ->leftJoin('employees','employees.id','issue_registers.employee_id')
              ->leftJoin('categories','categories.id','issue_registers.category_id')
              ->leftJoin('departments','departments.id','employees.department_id')
              ->leftJoin('units','units.id','employees.unit_id')
              ->leftJoin('users','users.id','issue_registers.assign_task_status')
              ->leftJoin('supportdetails','supportdetails.support_id','issue_registers.id')
              ->orderBy('supportdetails.id','desc')
              ->where('issue_registers.id',$issue_register->id)
              ->get();


// return dd($task_details);

// if (!empty($request->send_email)) {

//       \Mail::to($employee_email->employee_email)
//        // ->cc(['itteam@uniquegroupbd.com'])
//        ->send(new \App\Mail\Mycontactemail($task_details));

// }

// else{
  
//       \Mail::to($employee_email->employee_email)
//        // ->cc(['itteam@uniquegroupbd.com'])
//        ->send(new \App\Mail\Mycontactemail($task_details));

// }



        // $setting->path = '/storage/'.$path;
        return response()->json(['success' => 'Support Added successfully']);
    }  


    public function assign_task_user(Request $request)
    {

          $validator = Validator::make($request->all(), [
                    "issue_register_id" => "required",
                    "user_task_id" => "required",
        ]);


// return dd($request);

        // if ($validator->fails()) {
        //       return redirect()->back()->withErrors($validator->errors());
        //     // return response()->json(['errors' => $validator->errors()->all()], 400);
        // }

           if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

// return dd($request->user_task_id);


           if (!empty($request->issue_register_id)) {

              $user_employee_data = DB::table('users')
                                ->select('employee_id')
                                ->where('id',$request->user_task_id)
                                ->first();
              $employee_id = $user_employee_data->employee_id;

                    // dd($user_employee_data->employee_id);
              $data = array(
                  'assign_task_status'=> $request->user_task_id,
                  'assigned_employee_status'=> 'other',
                  'assigned_to'=> $employee_id,
                  'assigned_from'=> Auth::user()->employee_id,
              );

              $update_data = DB::table('issue_registers')
                            ->where('id',$request->issue_register_id)
                            ->update($data);

                $assign_user = Assigntask::updateOrCreate(

        ['id'   => $request->id],
          [
          'issue_register_id'    => $request->issue_register_id,
          'assign_date'          => Carbon::now(),
          'assign_task_fron'     => Auth::user()->employee_id,
          'assign_task_to'       => $request->user_task_id,
          'remarks'              => $request->remarks,
          'assigntasks_oder'     => 1,
          'created_by'           => Auth::id(),
          ],
     
        );
        
        }
        else{
               $assign_user = Assigntask::updateOrCreate(

        ['id'   => $request->id],
        [
          'issue_register_id'    => $request->issue_register_id,
          'assign_date'          => Carbon::now(),
          'assign_task_fron'     => Auth::id(),
          'assign_task_to'       => $request->user_task_id,
          'remarks'             => $request->remarks,
          'assigntasks_oder'     => 1,
          'created_by'           => Auth::id(),
        ],
     
        );
        }

        // $setting->path = '/storage/'.$path;
        return response()->json(['success' => 'Assign Task Added successfully']);
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



     public function export() 
    {

          $employee_lists = DB::table('employees')
                        ->select(
                            'employees.id as emp_id',
                            'employees.employee_id',
                            'employees.employee_name',
                            'employees.unit_id',
                            'employees.department_id',
                            'employees.location_id',
                            'locations.id',
                            'locations.location_name',
                            'units.id',
                            'units.unit_name'
                        )
                        ->leftJoin('units','units.id','=','employees.unit_id')
                        ->leftJoin('locations','locations.id','=','employees.location_id')
                        ->get();
                
        // return Excel::download(new EmployeeExport, 'employee_lists.xlsx');
        return Excel::download(new EmployeeExport($employee_lists), 'employee_lists.xlsx');
          // return back();
    }

     public function importexcelfile() 
    {

                

        return Excel::download(new SampleImportFormatExport, 'sample_import_format.xlsx');
          // return back();
    }
     

    // public function import(Request $request) 
    // {

    //     // dd($request->category_id);
    //     // dd(request()->file('file'));
    //   $category_id = $request->category_id;
    //     $file = request()->file('file');
    //     Excel::import(new TaskImport,request()->file('file'),$category_id);
             
    //     return back();
    // }

     public function import(Request $request)
    {
        // Validate the file and custom parameter (e.g., role)
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            // 'role_id' => 'required|integer|exists:roles,id',  // Custom validation for role_id
        ]);

        // Retrieve the uploaded file and role_id from the request
        $file = $request->file('file');
        $category_id = $request->input('category_id');
        $title = $request->input('task_title');


        // return dd($title);

        // Pass the file and custom parameter to the import class
        // Excel::import(new TaskImport($category_id,$title), $file);

Excel::import(new TaskImport,request()->file('file'));

        return back()->with('success', 'Task Upload File imported successfully with the selected Category and Task Title.');
    }



}
