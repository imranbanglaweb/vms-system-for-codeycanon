<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Setting;
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

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $sliders = Slider::orderBy('id','ASC')->get();
        return view('admin.dashboard.slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $menus = Menu::get();
        $sliders = Slider::orderBy('id','DESC')->get();
        return view('admin.dashboard.slider.create',compact('sliders'));
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
                    "slider_name" => "required",
                    // "site_description" => "required",
        ]);

        // if ($validator->fails()) {
        //       return redirect()->back()->withErrors($validator->errors());
        //     // return response()->json(['errors' => $validator->errors()->all()], 400);
        // }

          if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

        $slider = New Slider;

        if ($request->file('slider_image')) {
            $imagePath = $request->file('slider_image');
       $request->validate([
          'slider_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            $slider_image = $imagePath->getClientOriginalName();

            // $path = $request->file('site_logo')->storeAs('admin_resource\assets\images', $imageName, 'public');
            // $path = public_path().'//images';
            //   $imagePath->move($path, $imageName);

 $slider_image = time().'.'.$request->slider_image->extension();  
     
  $request->slider_image->move(public_path('admin_resource\assets\images'), $slider_image);

        }


        $slider->slider_name    = $request->slider_name;
        $slider->slider_caption = $request->slider_caption;
        $slider->slider_content = $request->slider_content;
        $slider->slider_oder    = $request->slider_oder;

        if (!empty($slider_image)) {
            
             $slider->slider_image = $slider_image;
        }

        $slider->created_by = Auth::id();
        // $setting->path = '/storage/'.$path;
        $slider->save();

        return response()->json('Slider Updated Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Slider::find($id)->delete();
        return redirect()->route('sliders.index')
                        ->with('danger','Slider deleted successfully');
    }
}
