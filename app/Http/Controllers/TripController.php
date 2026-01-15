<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        return view('admin.trips.index');
    }

    public function create()
    {
        return view('admin.trips.create');
    }

    public function store(Request $request)
    {
        // Implementation
    }

    public function show($id)
    {
        // Implementation
    }

    public function edit($id)
    {
        // Implementation
    }

    public function update(Request $request, $id)
    {
        // Implementation
    }

    public function destroy($id)
    {
        // Implementation
    }
}