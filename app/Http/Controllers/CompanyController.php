<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Company;
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


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                        $companies = DB::table('companies')
                        ->select('companies.id as c_id','companies.company_name','companies.company_code','units.*')
                        ->leftJoin('units','companies.unit_id','=','units.id')
                        ->get();
        return view('admin.dashboard.company.index',compact('companies'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $units = Unit::get();
        return view('admin.dashboard.company.create',compact('units'));
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
                    "company_name" => "required",
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


           if (!empty($request->company_name)) {
                $company = Company::updateOrCreate(

        ['id'   => $request->id],
        [
        'company_name'      => $request->company_name,
        'company_code'   => $request->company_code,
        'unit_id'   => $request->unit_id,
        'remarks'     => $request->remarks,
        'created_by' => Auth::id(),
        ],
     
        );
        
        }
        else{
               $event = Company::updateOrCreate(

        ['id'   => $request->id],
        [
        'company_name'      => $request->company_name,
        'company_code'   => $request->company_code,
        'unit_id'   => $request->unit_id,
        'remarks'     => $request->remarks,
        'created_by' => Auth::id(),
        ],
     
        );
        }


        // $setting->path = '/storage/'.$path;


        return response()->json('Company Added Successfully');

        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
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
                 $unit_edit = Unit::find($id);
        return view('admin.dashboard.unit.edit',compact('unit_edit'));
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
                       Company::find($id)->delete();
        return redirect()->route('units.index')
                        ->with('danger','Unit Deleted successfully');
    }


}
