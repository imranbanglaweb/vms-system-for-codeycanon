<?php

namespace App\Http\Controllers;

use App\Models\Event;
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

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $events = Event::orderBy('id','ASC')->get();
        return view('admin.dashboard.event.index',compact('events'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
        return view('admin.dashboard.event.create');
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
                    "event_name" => "required",
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

        if ($request->file('event_main_image')) {
            $imagePath = $request->file('event_main_image');
       $request->validate([
          'event_main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            $event_main_image = $imagePath->getClientOriginalName();

            // $path = $request->file('site_logo')->storeAs('admin_resource\assets\images', $imageName, 'public');
            // $path = public_path().'//images';
            //   $imagePath->move($path, $imageName);

 $event_main_image = time().'.'.$request->event_main_image->extension();  
     
  $request->event_main_image->move(public_path('admin_resource\assets\images'), $event_main_image);

        }
           if (!empty($event_main_image)) {
                $event = Event::updateOrCreate(

        ['id'   => $request->id],
        [
        'event_name'      => $request->event_name,
        'event_content'   => $request->event_content,
        'event_main_image'     => $event_main_image,
        'created_by' => Auth::id(),
        ],
     
        );
        
        }
        else{
               $event = Event::updateOrCreate(

        ['id'   => $request->id],
        [
        'event_name'      => $request->event_name,
        'event_content'   => $request->event_content,
        'event_main_image'     => '',
        'created_by' => Auth::id(),
        ],
     
        );
        }


        // $setting->path = '/storage/'.$path;


        return response()->json('Event Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
                 $event_edit = Event::find($id);
        return view('admin.dashboard.event.edit',compact('event_edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

                    Event::find($id)->delete();
        return redirect()->route('events.index')
                        ->with('danger','Event Deleted successfully');

    }
}
