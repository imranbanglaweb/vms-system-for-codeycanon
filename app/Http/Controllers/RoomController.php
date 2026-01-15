<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomImage;
use App\Models\Category;
use App\Models\Roomdetail;
use App\Models\RoomService;
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

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $rooms = Room::orderBy('id','DESC')->get();
              $category_lists = Category::orderBy('id','DESC')->get();
        return view('admin.dashboard.rooms.index',compact('rooms','category_lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
              $menus = Room::orderBy('id','DESC')->get();
              $category_lists = Category::orderBy('id','DESC')->get();
        return view('admin.dashboard.rooms.create',compact('category_lists'));
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
                    "room_name" => "required",
                    // "room_discription" => "required",
                    // "room_service_id" => "required",
                    "room_available" => "required",
                    // "room_main_image" => "required",
        ]);


   // return dd($request->room_main_image[0]->getClientOriginalName());
// exit();
        // if ($validator->fails()) {
        //       return redirect()->back()->withErrors($validator->errors());
        //     // return response()->json(['errors' => $validator->errors()->all()], 400);
        // }

           if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }


            if (!empty($service_id)) {
              
        $service_id = count($request->room_service_id);
            }

         if ($request->hasFile('room_main_image')) {
                $room = Room::updateOrCreate(

        ['id'   => $request->id],
        [
        'room_name'          => $request->room_name,
        'room_type'          => $request->room_type,
        'room_discription'   => $request->room_discription,
        'room_guests'        => $request->room_guests,
        'min_booking'        => $request->min_booking,
        'room_bed_size'      => $request->room_bed_size,
        'room_size_sft'      => $request->room_size_sft,
        'room_available'     => $request->room_available,
        'room_offer'         => $request->room_offer,
        'room_booking'       => $request->room_booking,
        'room_oder'          => $request->room_oder,
        'amount'             => $request->amount,
        'room_main_image'    => $request->room_main_image[0]->getClientOriginalName(),
        'remarks'            => $request->remarks,
        'created_by' => 1,
        ],
    
   );

                 $imageNameArr = [];
            foreach ($request->room_main_image as $key=> $file) {
                // you can also use the original name
            $imageName = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $imageName = time().'-'.$imageName;
                // return dd($imageName);
                $imageNameArr[] = $imageName;
                // Upload file to public path in images directory
                // Database operation
                 $file->move(public_path('admin_resource\assets\images'), $imageName);
                 $room_image= new RoomImage();
                 $room_image->room_id      = $room->id;
                 $room_image->room_image  = $imageName;
                 $room_image->created_by  = 1;
                 $room_image->save();
            
            }
        

    if (!empty($service_id)) {
             for($i=0; $i < $service_id; $i++){

                    $room_details = New Roomdetail;
                    $room_details->room_id      = $room->id;
                    $room_details->service_id   = $request->room_service_id[$i];
                    $room_details->created_by     = 1;
                    $room_details->save();

                 // return dd($request);
                }
            }
        
        }
        else{

               $room = Room::updateOrCreate(

            ['id'   => $request->id],
            [
            'room_name'          => $request->room_name,
            'room_type'          => $request->room_type,
            'room_discription'   => $request->room_discription,
            'room_guests'        => $request->room_guests,
            'min_booking'        => $request->min_booking,
            'room_available'     => $request->room_available,
            'room_bed_size'      => $request->room_bed_size,
            'room_size_sft'      => $request->room_size_sft,
            'room_offer'         => $request->room_offer,
            'room_booking'       => $request->room_booking,
            'room_oder'          => $request->room_oder,
            'amount'             => $request->amount,
            'room_main_image'    => $request->room_main_image,
            'remarks'            => $request->remarks,
            'room_main_image'    => '',
            'created_by' => Auth::id(),
            ],
         
            );


             for($i=0; $i < $service_id; $i++){

                    $room_details = New Roomdetail;
                    $room_details->room_id      = $request->room_id;
                    $room_details->service_id   = $room_service_id[$i];
                    $room_details->added_by     = $user->id;
                    $room_details->save();

                 // return dd($request);
            }
        }


        // $setting->path = '/storage/'.$path;


        return response()->json('Room Added Successfully');


    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

              $room_detail = Room::find($id);
              $service_details= Roomdetail::find($id);
              $room_services = DB::table('room_services')->where('room_id',$id)->get();
              $room_images= RoomImage::where('room_id',$id)->get();
              // return dd($room_images);

        return view('admin.dashboard.rooms.details',compact('room_detail','room_services','room_images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
