<?php

namespace App\Http\Controllers;

use App\Models\Frontend;
use App\Models\Page;
use App\Models\Room;
use App\Models\Contact;
use App\Models\RoomService;
use Illuminate\Http\Request;
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
use App\Http\Requests;
Use Redirect;
Use Session;
Use Mail;
class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return redirect()->route('login');
        return view('frontend.home');

    }

    public function roomsandsuites(){

         // return view('frontend.pages.roomsandsuites');

            $room_lists = Room::orderBy('id','DESC')->get();
        return view('frontend.pages.roomsandsuites',compact('room_lists'));
        
    }

    public function dinning(){

 $room_lists = Room::orderBy('id','DESC')->get();
         return view('frontend.pages.dinning');
    }

    public function meetingsandevents(){

         return view('frontend.pages.events');
    }

    public function gallery(){

         return view('frontend.pages.gallary');
    }

    public function privilegemember(){

         return view('frontend.pages.privilege_member');
    }


    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function about()
    {

        $about_us_page= Page::where('id',3)->first();
        return view('frontend.pages.about',compact('about_us_page'));

    }



    
    public function bookonline(Request $request)
    {

         $room_services= RoomService::orderBy('id','DESC')->get();
         $room_lists= Room::orderBy('id','DESC')->get();

         $search = $request->search;
       $arrival_date = $request->arrival_date;
         $departure_date = $request->departure_date;
         $adult = $request->adult;
         $children = $request->children;
         $guest = $request->guest;
         $amount = $request->amount;
         $service_id = $request->service_id;
         $search = $request->search;
         $data = array(
            'arrival_date'      =>$arrival_date,
            'departure_date'      =>$departure_date,
            'adult'      =>$adult,
            'children'   =>$children,
            'guest'      =>$guest,
            'amount'     =>$amount,
            'service_id' =>$service_id,
            'search'     =>$search,
         );

         if (!empty($request->search)) {

  



            // $room_lists= DB::table('rooms')->where('adult',$adult)->get();

            $room_lists = Room::where('adult', $adult)
                        ->orWhere('children',$children)
                        // ->orWhere('amount','like','%'.$amount.'%')
                        ->orWhere('amount',$amount)
                        ->get();
             // return dd($room_lists);
         }


        return view('frontend.pages.bookonline',compact('room_services','room_lists','search','data'));


    }


    // room Details 
    public function roomdetails($id){

        // $id = $request->get('id');
        // return $id;
            $counter  = DB::table('rooms')->count();
            $room_details = Room::find($id);
        // return dd($room_details);

        return view('frontend.pages.room_details',compact('room_details','counter'));

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Frontend  $frontend
     * @return \Illuminate\Http\Response
     */
    public function show(Frontend $frontend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Frontend  $frontend
     * @return \Illuminate\Http\Response
     */
    public function edit(Frontend $frontend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Frontend  $frontend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Frontend $frontend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Frontend  $frontend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Frontend $frontend)
    {
        //
    }


    public function contactstore(Request $request){

           $validator = Validator::make($request->all(), [
                    "contact_name" => "required",
                    // "site_description" => "required",
        ]);

        // if ($validator->fails()) {
        //       return redirect()->back()->withErrors($validator->errors());
        //     // return response()->json(['errors' => $validator->errors()->all()], 400);
        // }

           if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }


    $contacts = Contact::updateOrCreate(

        ['id'   => $request->id],
            [
                'contact_name'   => $request->contact_name,
                'contact_mobile'   => $request->contact_mobile,
                'contact_email'   => $request->contact_email,
                'contact_content'   => $request->contact_content,
                'ip_address'   => $request->ip_address,
                'mac_address'   => $request->mac_address,
                'created_by' => 1,
            ],
        );

     $details = [
        'title' => $request->contact_name,
        'body' => $request->contact_content,
        'from_email' => $request->contact_email
    ];



     // \Mail::send('admin.dashboard.email.contactlistemail', array(
     //        'contact_name' => $request->get('contact_name'),
     //        'contact_email' => $request->get('contact_email'),
     //        'contact_mobile' => $request->get('contact_mobile'),
     //        'contact_content' => $request->get('contact_content'),
     //    ), function($message) use ($request){
     //        $message->from('');
     //        $message->to('imran@uniquegroupbd.com', 'Admin')->subject($request->get('contact_name'));
     //    });



      // Mail::send('email', [
      //           'contact_name' => $request->contact_name,
      //           'contact_mobile' => $request->contact_mobile,
      //           'contact_email' => $request->contact_email ],
      //           function ($message) {
      //                   $message->from($request->contact_email);
      //                   $message->to( $request->contact_email, 'Your Name')
      //                           ->subject('Your Website Contact Form');
      //   });

      \Mail::to('md.imran1200@gmail.com')->send(new \App\Mail\Mycontactemail($details));


    //  Send mail to admin
        // \Mail::send('admin.dashboard.contactlist.contactMail', array(
        //     'contact_name' => $request['contact_name'],
        //     'contact_email' => $request['contact_email'],
        //     'contact_mobile' => $request['contact_mobile'],
        //     'subject' => $request['subject'],
        //     'message' => $request['message'],
        // ), function($message) use ($request){
        //     $message->from($request->email);
        //     $message->to('md.imran1200@gmail.com', 'Admin')->subject($request->get('subject'));
        // });
        return response()->json('Your Information  Added Successfully');

    }


    public function contactlistviewdelete($id){

            Contact::find($id)->delete();
        return redirect()->route('contactlistview')
                        ->with('danger','Contact Info Deleted successfully');

    }




}
