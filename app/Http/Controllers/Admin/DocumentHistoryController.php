<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentHistoryController extends Controller
{
    public function index()
    {
        return view('admin.document-history.index');
    }

    public function search(Request $request)
    {
        // Implementation
    }

    public function export()
    {
        // Implementation
    }
}