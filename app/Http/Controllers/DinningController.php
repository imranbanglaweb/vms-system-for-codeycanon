<?php

namespace App\Http\Controllers;

use App\Models\Dinning;
use App\Models\Dinningimage;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

class DinningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                 $dinning_lists = DB::table('dinnings')
                 // ->select('dinnings.id as d_id','dinnings.dinning_name','dinnings.dinning_content','dinnings.mobile','categories.id','categories.category_name')
                 // ->join('categories', 'categories.id', '=', 'dinnings.dinning_category')
                 ->get();
              $category_lists = Category::orderBy('id','DESC')->get();

              $dinning_images = DB::table('dinningimages')->get();
        return view('admin.dashboard.dinning.index',compact('dinning_lists','category_lists','dinning_images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
         $menus = Dinning::orderBy('id','DESC')->get();
         $category_lists = Category::orderBy('id','DESC')->get();

        return view('admin.dashboard.dinning.add',compact('category_lists'));


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
                    "dinning_name" => "required",
                    // "room_discription" => "required",
                    // "room_service_id" => "required",
                    "dinning_content" => "required",
                    // "room_main_image" => "required",
        ]);


//    return dd($request);
// exit();
        // if ($validator->fails()) {
        //       return redirect()->back()->withErrors($validator->errors());
        //     // return response()->json(['errors' => $validator->errors()->all()], 400);
        // }

           if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

         if ($request->hasFile('dinning_main_image')) {
                $dinning = Dinning::updateOrCreate(

        ['id'   => $request->id],
        [
        'dinning_name'          => $request->dinning_name,
        'dinning_content'       => $request->dinning_content,
        'dinning_category'      => $request->dinning_category,
        'mobile'                => $request->mobile,
        'email'                 => $request->email,
        // 'room_main_image'    => $room_main_image,
        'dinning_oder'          => 1,
        'created_by' => 1,
        ],
    
   );

                 $imageNameArr = [];
            foreach ($request->dinning_main_image as $key=> $file) {
                // you can also use the original name
            $imageName = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $imageName = time().'-'.$imageName;
                // return dd($imageName);
                $imageNameArr[] = $imageName;
                // Upload file to public path in images directory
                // Database operation
                 $file->move(public_path('admin_resource\assets\images'), $imageName);
                 $dinning_image= new Dinningimage();
                 $dinning_image->dinning_id       = $dinning->id;
                 $dinning_image->dinning_image  = $imageName;
                 $dinning_image->created_by  = 1;
                 $dinning_image->save();
            
            }
        
        
        }
        else{

               $dinning = Dinning::updateOrCreate(

            ['id'   => $request->id],
            [
                'dinning_name'          => $request->dinning_name,
                'dinning_content'       => $request->dinning_content,
                'dinning_category'      => $request->dinning_category,
                'mobile'                => $request->mobile,
                'email'                => $request->email,
                // 'room_main_image'    => $room_main_image,
                'dinning_main_image'    => $request->dinning_main_image,
                'dinning_oder'          => 1,
                'created_by' => 1,
            ],
         
            );


        }


        // $setting->path = '/storage/'.$path;

        return response()->json('Dinning Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dinning  $dinning
     * @return \Illuminate\Http\Response
     */
    public function show(Dinning $dinning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dinning  $dinning
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
           $dinning_edit = Dinning::find($id);
           $dinning_images = DB::table('dinningimages')->get();
           $category_lists = Category::orderBy('id','DESC')->get();

            // return dd($dinning_edit);
    return view('admin.dashboard.dinning.edit',compact('dinning_edit','dinning_images','category_lists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dinning  $dinning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dinning $dinning)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dinning  $dinning
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

            Dinning::find($id)->delete();
        return redirect()->route('dinning-manage.index')
                        ->with('danger','Dinning Deleted successfully');
    }
}
