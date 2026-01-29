<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the email templates.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $templates = EmailTemplate::withTrashed()->select(['email_templates.*'])
                ->latest('email_templates.created_at');

            return DataTables::of($templates)
                ->addIndexColumn()
                ->addColumn('type_label', function ($row) {
                    $types = EmailTemplate::getTemplateTypes();
                    return $types[$row->type] ?? $row->type;
                })
                ->addColumn('is_active', function ($row) {
                    if ($row->trashed()) {
                        return '<span class="badge bg-secondary">Deleted</span>';
                    }
                    return $row->is_active 
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('email-templates.edit', $row->id);
                    $showUrl = route('email-templates.show', $row->id);
                    
                    $editBtn = '<a href="' . $editUrl . '" class="btn btn-primary btn-sm" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>';
                    
                    $showBtn = '<a href="' . $showUrl . '" class="btn btn-info btn-sm" title="View">
                        <i class="fa fa-eye"></i>
                    </a>';
                    
                    $toggleBtn = '<button class="btn btn-warning btn-sm toggleStatusBtn" 
                        data-id="' . $row->id . '" 
                        data-active="' . ($row->is_active ? '1' : '0') . '" 
                        title="' . ($row->is_active ? 'Deactivate' : 'Activate') . '">
                        <i class="fa fa-toggle-' . ($row->is_active ? 'on' : 'off') . '"></i>
                    </button>';
                    
                    $deleteBtn = '<button class="btn btn-danger btn-sm deleteTemplateBtn" 
                        data-id="' . $row->id . '" 
                        title="Delete">
                        <i class="fa fa-trash"></i>
                    </button>';
                    
                    return $editBtn . ' ' . $showBtn . ' ' . $toggleBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('admin.dashboard.email-templates.index');
    }

    /**
     * Show the form for creating a new email template.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templateTypes = EmailTemplate::getTemplateTypes();
        return view('admin.dashboard.email-templates.create', compact('templateTypes'));
    }

    /**
     * Store a newly created email template in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:email_templates,name',
            'slug' => 'required|string|max:255|unique:email_templates,slug',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|string|in:' . implode(',', array_keys(EmailTemplate::getTemplateTypes())),
            'variables' => 'nullable|json',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $template = EmailTemplate::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'subject' => $request->subject,
                'body' => $request->body,
                'type' => $request->type,
                'variables' => $request->variables ? json_decode($request->variables) : null,
                'is_active' => $request->is_active ?? true,
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Email template created successfully!',
                'redirect' => route('email-templates.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('EmailTemplate store error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the template.'
            ], 500);
        }
    }

    /**
     * Display the specified email template.
     *
     * @param EmailTemplate $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplate $emailTemplate)
    {
        return view('admin.dashboard.email-templates.show', compact('emailTemplate'));
    }

    /**
     * Show the form for editing the specified email template.
     *
     * @param EmailTemplate $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        $templateTypes = EmailTemplate::getTemplateTypes();
        return view('admin.dashboard.email-templates.edit', compact('emailTemplate', 'templateTypes'));
    }

    /**
     * Update the specified email template in storage.
     *
     * @param Request $request
     * @param EmailTemplate $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:email_templates,name,' . $emailTemplate->id,
            'slug' => 'required|string|max:255|unique:email_templates,slug,' . $emailTemplate->id,
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|string|in:' . implode(',', array_keys(EmailTemplate::getTemplateTypes())),
            'variables' => 'nullable|json',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $template = $emailTemplate->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'subject' => $request->subject,
                'body' => $request->body,
                'type' => $request->type,
                'variables' => $request->variables ? json_decode($request->variables) : null,
                'is_active' => $request->is_active ?? true,
                'updated_by' => Auth::id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Email template updated successfully!',
                'redirect' => route('email-templates.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('EmailTemplate update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the template.'
            ], 500);
        }
    }

    /**
     * Remove the specified email template from storage.
     *
     * @param EmailTemplate $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        try {
            $emailTemplate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Email template deleted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('EmailTemplate destroy error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the template.'
            ], 500);
        }
    }

    /**
     * Toggle the active status of the email template.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:email_templates,id',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request.'
            ], 422);
        }

        try {
            $template = EmailTemplate::findOrFail($request->id);
            $template->is_active = $request->is_active;
            $template->updated_by = Auth::id();
            $template->save();

            $status = $request->is_active ? 'activated' : 'deactivated';

            return response()->json([
                'success' => true,
                'message' => "Email template {$status} successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('EmailTemplate toggleStatus error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the template status.'
            ], 500);
        }
    }

    /**
     * Restore a soft-deleted email template.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try {
            $template = EmailTemplate::withTrashed()->findOrFail($id);
            $template->restore();

            return response()->json([
                'success' => true,
                'message' => 'Email template restored successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('EmailTemplate restore error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while restoring the template.'
            ], 500);
        }
    }
}
