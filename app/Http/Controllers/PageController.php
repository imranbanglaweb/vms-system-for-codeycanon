<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
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

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
               
          $pages = Page::orderBy('page_oder','ASC')->paginate(100);
        return view('admin.dashboard.pages.index',compact('pages'))
            ->with('i', ($request->input('pages', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


       // $menus = Menu::get();
        $pages = Page::orderBy('id','DESC')->get();
        return view('admin.dashboard.pages.create',compact('pages'));
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
                    "page_name" => "required",
                    // "page_description" => "required",
        ]);

        if ($validator->fails()) {
              return redirect()->back()->withErrors($validator->errors());
            // return response()->json(['errors' => $validator->errors()->all()], 400);
        }
   


        if ($request->file('page_image')) {

            $imagePath = $request->file('page_image');
       $request->validate([
          'page_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

            $page_image = $imagePath->getClientOriginalName();

            // $path = $request->file('site_logo')->storeAs('admin_resource\assets\images', $imageName, 'public');
            // $path = public_path().'//images';
            //   $imagePath->move($path, $imageName);

 $page_image = time().'.'.$request->page_image->extension();  
     
  $request->page_image->move(public_path('admin_resource\assets\images'), $page_image);

        }


            if (!empty($page_image)) {

                $page = Page::updateOrCreate(

        ['id'   => $request->id],
        [
        'page_name'          => $request->page_name,
        'page_description'   => $request->page_description,
        'page_slug'          => \Str::slug($request->page_name),
        'page_link'          => $request->page_link,
        'page_image'         => $page_image,
        // 'created_by'         => Auth::id(),
        ],
     
        );
        
        }
        
        else{
               $page = Page::updateOrCreate(

        ['id'   => $request->page_id],
        [
         'page_name'         => $request->page_name,
        'page_description'   => $request->page_description,
        'page_slug'          => \Str::slug($request->page_name),
        'page_link'          => $request->page_link,
        'page_image'         => '',
        ],
     
        );
        }

   
        return redirect()->route('pages.index')
                        ->with('success','Page Update Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {

        $page_edit = Page::find($id);
    
        return view('admin.dashboard.pages.edit',compact('page_edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Page::find($id)->delete();
        return redirect()->route('pages.index')
                        ->with('danger','Page Deleted successfully');
    }
}
