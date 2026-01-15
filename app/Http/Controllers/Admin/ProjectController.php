<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $projects = Project::latest()->get();
            return response()->json([
                'success' => true,
                'data' => $projects,
                'view' => view('admin.dashboard.projects.table', compact('projects'))->render()
            ]);
        }
        
        $projects = Project::latest()->paginate(10);
        return view('admin.dashboard.projects.index', compact('projects'));
    }

    public function create()
    {
        try {
            return response()->json([
                'success' => true,
                'view' => view('admin.dashboard.projects.create_modal')->render()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading form: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_name' => 'required|string|max:255|unique:projects',
            'project_description' => 'nullable|string',
            // 'start_date' => 'required|date',
            // 'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,completed,on-hold'
        ]);

        $user = Auth::user();

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Project::create($request->all());

                $projects = new Project();
                $projects->project_name     = $request->project_name;
                $projects->project_description     = $request->project_description;
                $projects->status     = 'Active';
                $projects->created_by    = $user->id;
                $projects->save();

            return response()->json([
                'success' => true,
                'message' => 'Project created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating project: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $project = Project::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $project,
                'view' => view('admin.dashboard.projects.edit_modal', compact('project'))->render()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading project: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'project_name' => 'required|string|max:255|unique:projects,project_name,' . $id,
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,completed,on-hold'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $project = Project::findOrFail($id);
            $project->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating project: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();
            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting project: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $project = Project::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $project,
                'view' => view('admin.dashboard.projects.view_modal', compact('project'))->render()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading project: ' . $e->getMessage()
            ], 500);
        }
    }
} 