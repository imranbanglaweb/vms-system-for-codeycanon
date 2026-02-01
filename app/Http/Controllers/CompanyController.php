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
        return view('admin.dashboard.company.index');
    }

    /**
     * Get data for DataTables
     */
    public function data()
    {
        $companies = Company::select(['id', 'company_name', 'company_code']);
        
        return DataTables::of($companies)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<div class="action-btns">';
                $btn .= '<button class="btn btn-primary btn-sm editCompany" data-id="'.$row->id.'" data-name="'.$row->company_name.'" data-code="'.$row->company_code.'"><i class="fa fa-edit"></i> Edit</button>';
                $btn .= '<button class="btn btn-danger btn-sm deleteCompany" data-id="'.$row->id.'"><i class="fa fa-trash"></i> Delete</button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.dashboard.company.create');
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
              'company_name' => 'required|string|max:255',
              'company_code' => 'required|string|max:50|unique:companies,company_code',
          ]);

          if ($validator->fails()) {
              return response()->json(['errors' => $validator->errors()->all()], 400);
          }

          $company = Company::updateOrCreate(
              ['id' => $request->id],
              [
                  'company_name' => $request->company_name,
                  'company_code' => $request->company_code,
                  'unit_id' => $request->unit_id,
                  'remarks' => $request->remarks,
                  'status' => $request->status ?? 'active',
                  'created_by' => Auth::id(),
              ]
          );

          return response()->json(['message' => 'Company saved successfully']);
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
        $company = Company::findOrFail($id);
        $units = Unit::all();
        return view('admin.dashboard.company.edit', compact('company', 'units'));
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
        return response()->json(['message' => 'Company deleted successfully']);
    }


}
