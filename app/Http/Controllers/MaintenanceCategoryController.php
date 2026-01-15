<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class MaintenanceCategoryController extends Controller
{

        public function index(Request $request)
        {
      if ($request->ajax()) {

        $data = MaintenanceCategory::latest()->get();

        return datatables()->of($data)
            ->addIndexColumn()

            // Add Action Column
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-primary editBtn" data-id="'.$row->id.'">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->id.'">
                        <i class="fa fa-minus"></i>
                    </button>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

        $categories = MaintenanceCategory::where('parent_id',0)->get();
        return view('admin.dashboard.maintenance.maintenance_categories.index', compact('categories'));
        }

        public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:150|unique:maintenance_categories,category_name,' . $request->id,
            'category_type' => 'nullable|max:100',
        ]);

        MaintenanceCategory::updateOrCreate(
            ['id' => $request->id],
            [
                'category_name' => $request->category_name,
                'category_slug' => Str::slug($request->category_name),
                'category_type' => $request->category_type,
                'status' => 1,
                'created_by' => auth()->id(),
            ]
        );

        return response()->json(['message' => 'Category saved successfully']);
    }

        public function edit($id)
        {
        $category = MaintenanceCategory::findOrFail($id);
        return response()->json($category);
        }

        public function destroy($id)
        {
        MaintenanceCategory::findOrFail($id)->delete();
        return response()->json(['message' => 'Category deleted successfully']);
        }

}
