<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\Setting;
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
                ->addColumn('preview', function ($row) {
                    return '<button class="btn btn-secondary btn-sm previewTemplateBtn" 
                        data-id="' . $row->id . '" 
                        data-name="' . htmlspecialchars($row->name) . '" 
                        title="Preview">
                        <i class="fa fa-eye"></i>
                    </button>';
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
                ->rawColumns(['is_active', 'preview', 'action'])
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
            'greeting' => 'nullable|string',
            'content_text' => 'nullable|string',
            'footer_text' => 'nullable|string',
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
            // Merge greeting, content_text, and footer_text into variables
            $variables = $request->variables ? json_decode($request->variables, true) : [];
            if (!is_array($variables)) {
                $variables = [];
            }
            
            if ($request->greeting) {
                $variables['greeting'] = $request->greeting;
            }
            if ($request->content_text) {
                $variables['content_text'] = $request->content_text;
            }
            if ($request->footer_text) {
                $variables['footer_text'] = $request->footer_text;
            }
            
            $template = EmailTemplate::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'subject' => $request->subject,
                'body' => $request->body,
                'type' => $request->type,
                'variables' => !empty($variables) ? json_encode($variables) : null,
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
        
        // Create a temporary escaped version for the view (don't modify the model)
        $escapedBody = str_replace(
            ['{{', '}}', '@{{'],
            ['&#123;&#123;', '&#125;&#125;', '@&#123;&#123;'],
            $emailTemplate->body
        );
        
        // Pass both the original template and escaped body
        return view('admin.dashboard.email-templates.edit', [
            'emailTemplate' => $emailTemplate,
            'templateTypes' => $templateTypes,
            'escapedBody' => $escapedBody
        ]);
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
            'greeting' => 'nullable|string',
            'content_text' => 'nullable|string',
            'footer_text' => 'nullable|string',
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
            // Merge greeting, content_text, and footer_text into variables
            $variables = $request->variables ? json_decode($request->variables, true) : [];
            if (!is_array($variables)) {
                $variables = [];
            }
            
            if ($request->greeting) {
                $variables['greeting'] = $request->greeting;
            }
            if ($request->content_text) {
                $variables['content_text'] = $request->content_text;
            }
            if ($request->footer_text) {
                $variables['footer_text'] = $request->footer_text;
            }
            
            $template = $emailTemplate->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'subject' => $request->subject,
                'body' => $request->body,
                'type' => $request->type,
                'variables' => !empty($variables) ? json_encode($variables) : null,
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

    public function preview($id)
    {
        try {
            $template = EmailTemplate::findOrFail($id);
            
            // Get settings for dynamic variables
            $settings = Setting::first();
            $adminTitle = $settings && $settings->admin_title ? $settings->admin_title : 'InayaFleet360';
            $adminDescription = $settings && $settings->admin_description ? $settings->admin_description : 'All-in-One Fleet & Transport Automation System';
            $adminLogoUrl = $settings && $settings->admin_logo 
                ? asset('public/admin_resource/assets/images/' . $settings->admin_logo) 
                : '';
            
            // Prepare data for template rendering
            $data = [
                'recipient_name' => 'John Doe',
                'admin_title' => $adminTitle,
                'admin_description' => $adminDescription,
                'adminlogo_url' => $adminLogoUrl,
                'admin_logo_url' => $adminLogoUrl,
                'company_name' => $adminTitle,
                'year' => date('Y'),
            ];
            
            $rendered = $template->render($data);
            $subject = $rendered['subject'];
            $body = $rendered['body'];
            
            // Get logo URL for preview
            $logoUrl = $adminLogoUrl ?: null;
            $companyName = $adminTitle;
            
            // Check if it's a complete template
            $isCompleteTemplate = (
                stripos(trim($body), '<table') === 0 ||
                stripos($body, '<!DOCTYPE') !== false || 
                stripos($body, '<html') !== false ||
                stripos($body, '<head') !== false ||
                stripos($body, '<body') !== false
            );
            
            if ($isCompleteTemplate) {
                return $body;
            }
            
            // Wrap in premium email layout
            return $this->generatePreviewHtml($subject, $body, $companyName, $logoUrl);
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Failed to load preview: ' . e($e->getMessage()) . '</div>';
        }
    }
    
    /**
     * Generate preview HTML
     *
     * @param string $subject
     * @param string $body
     * @param string $companyName
     * @param string|null $logoUrl
     * @return string
     */
    protected function generatePreviewHtml(string $subject, string $body, string $companyName, ?string $logoUrl): string
    {
        $logoHtml = $logoUrl 
            ? '<img src="' . e($logoUrl) . '" alt="' . e($companyName) . '" style="max-width: 200px; height: auto; display: inline-block; margin-bottom: 10px;">'
            : '<h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: 0.5px;">' . e($companyName) . '</h1>';
        
        $year = date('Y');
        
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$subject}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; }
        .email-wrapper { padding: 40px 20px; }
        .email-container { max-width: 700px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); }
        .email-header { background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 35px 40px; text-align: center; }
        .email-content { padding: 40px; color: #64748b; font-size: 16px; line-height: 1.8; }
        .email-footer { background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 30px 40px; text-align: center; color: rgba(255,255,255,0.9); font-size: 13px; }
        .company-name { font-size: 24px; font-weight: 700; margin-bottom: 10px; }
        .tagline { color: rgba(255,255,255,0.85); font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        @media only screen and (max-width: 600px) {
            .email-wrapper { padding: 20px 10px; }
            .email-header, .email-content, .email-footer { padding: 25px 20px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                {$logoHtml}
                <p class="tagline">All-in-One Fleet & Transport Automation System</p>
            </div>
            <div class="email-content">
                <h2 style="margin: 0 0 25px 0; color: #1e293b; font-size: 24px; font-weight: 700;">Hello,</h2>
                <div>{$body}</div>
                <div style="margin-top: 30px; padding-top: 25px; border-top: 1px dashed #e2e8f0;">
                    <p style="margin: 0 0 8px 0; color: #1e293b; font-weight: 600;">Best regards,</p>
                    <p style="margin: 0; color: #64748b;">The {$companyName} Team</p>
                </div>
            </div>
            <div class="email-footer">
                <p style="margin: 0 0 10px 0; font-weight: 600;">{$companyName}</p>
                <p style="margin: 0 0 10px 0;">&copy; {$year} {$companyName}. All rights reserved.</p>
                <p style="margin: 0; opacity: 0.7;">This is an automated message. Please do not reply directly to this email.</p>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
    }
}
