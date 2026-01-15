<?php

namespace App\Http\Controllers;

use App\Models\Offer;
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

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $offers = Offer::orderBy('id','ASC')->get();
        return view('admin.dashboard.offer.index',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          
         // $menus = Menu::get();
        // $gallery_lists = Gallery::orderBy('id','DESC')->get();
        $offer_lists = Offer::orderBy('id','ASC')->get();
        return view('admin.dashboard.offer.add',compact('offer_lists'));
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
                    "offer_title" => "required",
                    "offer_caption" => "required",
                    "offer_time" => "required",
        ]);

        // if ($validator->fails()) {
        //       return redirect()->back()->withErrors($validator->errors());
        //     // return response()->json(['errors' => $validator->errors()->all()], 400);
        // }

           if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }



        if ($request->file('offer_image')) {
            $imagePath = $request->file('offer_image');
       $request->validate([
          'offer_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            $gallery_image = $imagePath->getClientOriginalName();

            // $path = $request->file('site_logo')->storeAs('admin_resource\assets\images', $imageName, 'public');
            // $path = public_path().'//images';
            //   $imagePath->move($path, $imageName);

 $offer_image = time().'.'.$request->offer_image->extension();  
     
  $request->offer_image->move(public_path('admin_resource\assets\images'), $offer_image);

        }
           if (!empty($offer_image)) {
                $offer = Offer::updateOrCreate(

        ['id'   => $request->id],
        [
        'offer_title'     => $request->offer_title,
        'offer_caption'   => $request->offer_caption,
        'offer_content'   => $request->offer_content,
        'offer_time'   => $request->offer_time,
        'offer_image'     => $offer_image,
        'created_by' => Auth::id(),
        ],
     
        );
        
        }
        else{
               $offer = Offer::updateOrCreate(

        ['id'   => $request->id],
        [
        'offer_title'     => $request->offer_title,
        'offer_caption'   => $request->offer_caption,
        'offer_content'   => $request->offer_content,
        'offer_time'   => $request->offer_time,
        'offer_image'     => '',
        'created_by' => Auth::id(),
        ],
     
        );
        }


        // $setting->path = '/storage/'.$path;


        return response()->json('Offer Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        
         $offer_edit = DB::table('offers')->where('id',$id)->first();
             return view('admin.dashboard.offer.edit',compact('offer_edit'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
