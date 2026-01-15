<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    public function index()
    {
        return view('admin.document-types.index');
    }

    public function create()
    {
        return view('admin.document-types.create');
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