<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Unit;
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


class UnitController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

         $units = Unit::orderBy('id','DESC')->get();
        return view('admin.dashboard.unit.index',compact('units'));


    }

    /**
     * Server-side data for DataTables
     */
    public function data(Request $request)
    {
        Log::info('UnitController@data called', ['url' => $request->fullUrl(), 'ajax' => $request->ajax()]);

        if ($request->has('test')) {
            return response()->json(['ok' => true, 'message' => 'test payload']);
        }

        try {
            $query = Unit::select(['id','unit_name','unit_code', 'description']);

            $dt = DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editBtn = "<button class='btn btn-sm btn-primary editUnit' data-id='".$row->id."' data-name='".htmlspecialchars($row->unit_name, ENT_QUOTES)."' data-code='".htmlspecialchars($row->unit_code, ENT_QUOTES)."' title='Edit'><i class='fa fa-edit'></i></button> ";
                    $deleteBtn = "<button class='btn btn-sm btn-danger deleteUser' data-uid='".$row->id."' title='Delete'><i class='fa fa-minus-circle'></i></button>";
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['action']);

            return $dt->make(true);
        } catch (\Exception $e) {
            Log::error('UnitController@data exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Server error while generating table data'], 500);
        }
    }


    public function create()
    {
         $units = Unit::get();
        return view('admin.dashboard.unit.create',compact('units'));
    }


    public function store(Request $request)
    {

          $validator = Validator::make($request->all(), [
                    "unit_name" => "required",
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


           if (!empty($request->unit_name)) {
                $unit = Unit::updateOrCreate(

        ['id'   => $request->id],
        [
        'unit_name'      => $request->unit_name,
        'unit_code'   => $request->unit_code,
        'created_by' => Auth::id(),
        ],
     
        );
        
        }
        else{
               $event = Unit::updateOrCreate(

        ['id'   => $request->id],
        [
        'unit_name'      => $request->unit_name,
        'unit_code'   => $request->unit_code,
        'created_by' => Auth::id(),
        ],
     
        );
        }


        // $setting->path = '/storage/'.$path;


        return response()->json('Unit Added Successfully');
        

    }


    public function show(Request $request)
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
                 $unit_edit = Unit::find($id);
        return view('admin.dashboard.unit.edit',compact('unit_edit'));
    }

 

  public function destroy($id,Request $request)
    {
        // prefer explicit id param, fall back to form value
        $unit_id = $id ?: $request->input('u_id');
        $unit = Unit::find($unit_id);
        if ($unit) {
            $unit->delete();
        }

        if ($request->ajax()) {
            return response()->json(['ok' => true, 'message' => 'Unit deleted successfully']);
        }

        return redirect()->route('units.index')
                        ->with('danger','Unit Deleted successfully');
    }


    /**
     * Debug endpoint: same as data() but accessible when APP_DEBUG is true.
     * This is intentionally restricted so it won't be exposed in production.
     */
    public function dataDebug(Request $request)
    {
        if (!config('app.debug')) {
            return response()->json(['error' => 'Not allowed'], 403);
        }

        Log::info('UnitController@dataDebug called', ['url' => $request->fullUrl(), 'ajax' => $request->ajax()]);

        if ($request->has('test')) {
            return response()->json(['ok' => true, 'message' => 'debug test payload']);
        }

        try {
            $query = Unit::select(['id','unit_name','unit_code']);

            $dt = DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editBtn = "<button class='btn btn-sm btn-primary editUnit' data-id='".$row->id."' data-name='".htmlspecialchars($row->unit_name, ENT_QUOTES)."' data-code='".htmlspecialchars($row->unit_code, ENT_QUOTES)."' title='Edit'><i class='fa fa-edit'></i></button> ";
                    $deleteBtn = "<button class='btn btn-sm btn-danger deleteUser' data-uid='".$row->id."' title='Delete'><i class='fa fa-minus-circle'></i></button>";
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['action']);

            return $dt->make(true);
        } catch (\Exception $e) {
            Log::error('UnitController@dataDebug exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Server error while generating table data (debug)'], 500);
        }
    }


}
