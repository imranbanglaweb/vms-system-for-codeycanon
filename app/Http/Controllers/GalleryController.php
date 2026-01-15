<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
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

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $category_lists = Category::orderBy('id','ASC')->get();
          $gallery_lists = DB::table('galleries')
                            ->select('galleries.id as g_id','galleries.gallery_name','galleries.gallery_image','galleries.gallery_description','categories.category_name')
                            ->leftJoin('categories', 'categories.id', '=', 'galleries.category_id')
                            ->get();
        return view('admin.dashboard.gallery.index',compact('gallery_lists','category_lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
         // $menus = Menu::get();
        $gallery_lists = Gallery::orderBy('id','DESC')->get();
        $category_lists = Category::orderBy('id','ASC')->get();
        return view('admin.dashboard.gallery.create',compact('gallery_lists','category_lists'));
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
                    "gallery_name" => "required",
                    // "site_description" => "required",
        ]);

        // if ($validator->fails()) {
        //       return redirect()->back()->withErrors($validator->errors());
        //     // return response()->json(['errors' => $validator->errors()->all()], 400);
        // }

           if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }



        if ($request->file('gallery_image')) {
            $imagePath = $request->file('gallery_image');
       $request->validate([
          'gallery_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            $gallery_image = $imagePath->getClientOriginalName();

            // $path = $request->file('site_logo')->storeAs('admin_resource\assets\images', $imageName, 'public');
            // $path = public_path().'//images';
            //   $imagePath->move($path, $imageName);

 $gallery_image = time().'.'.$request->gallery_image->extension();  
     
  $request->gallery_image->move(public_path('admin_resource\assets\images'), $gallery_image);

        }
           if (!empty($gallery_image)) {
            $gallery_image = $gallery_image;
        
        }
        else{
            $gallery_image = '';
        }
    $gallery = Gallery::updateOrCreate(

        ['id'   => $request->id],
        [
            'gallery_name'   => $request->gallery_name,
        'gallery_description'   => $request->gallery_description,
        'category_id'   => $request->category_id,
        'gallery_oder'   => $request->gallery_oder,
        'gallery_image'   => $gallery_image,
        'created_by' => Auth::id(),
        ],
     
        );


        // $setting->path = '/storage/'.$path;


        return response()->json('Gallery Added Successfully');
    }


    public function show(Gallery $gallery)
    {
        
    }


    public function edit($id)
    {

         $category_lists = Category::orderBy('id','ASC')->get();
         $gallery_edit = DB::table('galleries')->where('id',$id)->first();
         $galleries = Gallery::get();
             return view('admin.dashboard.gallery.edit',compact('gallery_edit','galleries','category_lists'));
    }



    public function destroy($id)
    {
           Gallery::find($id)->delete();
        return redirect()->route('galleries.index')
                        ->with('danger','Gallery Deleted successfully');
    }



}
