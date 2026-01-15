<?php

namespace App\Http\Controllers;

use App\Models\Roombooking;
use Illuminate\Http\Request;

class RoombookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           // $menus = Menu::get();
        $menus = Menu::orderBy('id','DESC')->get();
        return view('admin.dashboard.rooms.create',compact('menus'));
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
     * @param  \App\Models\Roombooking  $roombooking
     * @return \Illuminate\Http\Response
     */
    public function show(Roombooking $roombooking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roombooking  $roombooking
     * @return \Illuminate\Http\Response
     */
    public function edit(Roombooking $roombooking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roombooking  $roombooking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roombooking $roombooking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roombooking  $roombooking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roombooking $roombooking)
    {
        //
    }
}
