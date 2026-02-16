<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\EmailTemplate;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $templates = EmailTemplate::latest();
            return DataTables::of($templates)
                ->addIndexColumn()
                ->addColumn('type_label', function ($row) {
                    $types = EmailTemplate::getTemplateTypes();
                    return $types[$row->type] ?? $row->type;
                })
                ->addColumn('is_active', function ($row) {
                    return $row->is_active 
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('preview', function ($row) {
                    return '<button class="btn btn-info btn-sm previewTemplateBtn" data-id="' . $row->id . '" data-name="' . e($row->name) . '"><i class="fa fa-eye"></i></button>';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('email-templates.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> 
                           <button class="btn btn-danger btn-sm deleteTemplateBtn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['is_active', 'preview', 'action'])
                ->make(true);
        }
        return view('admin.dashboard.email-templates.index');
    }

    public function create()
    {
        $types = EmailTemplate::getTemplateTypes();
        return view('admin.dashboard.email-templates.create', compact('types'));
    }

    public function store(Request $request)
    {
        return $this->saveTemplate($request);
    }

    public function show(EmailTemplate $emailTemplate)
    {
        return view('admin.dashboard.email-templates.show', compact('emailTemplate'));
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        $types = EmailTemplate::getTemplateTypes();
        return view('admin.dashboard.email-templates.edit', compact('emailTemplate', 'types'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        return $this->saveTemplate($request, $emailTemplate);
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return response()->json(['success' => true, 'message' => 'Template deleted successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        $template = EmailTemplate::findOrFail($request->id);
        $template->is_active = $request->is_active;
        $template->save();
        return response()->json(['success' => true, 'message' => 'Status updated.']);
    }

    public function restore($id)
    {
        $template = EmailTemplate::withTrashed()->findOrFail($id);
        $template->restore();
        return response()->json(['success' => true, 'message' => 'Template restored.']);
    }

    public function preview($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return $template->body;
    }

    private function saveTemplate(Request $request, EmailTemplate $emailTemplate = null)
    {
        $isUpdate = $emailTemplate ? true : false;

        // Validate and return JSON response if validation fails
        $validator = \Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('email_templates', 'name')->ignore($emailTemplate?->id)
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('email_templates', 'slug')->ignore($emailTemplate?->id)
            ],
            'type' => [
                'required',
                Rule::in(array_keys(EmailTemplate::getTemplateTypes()))
            ],
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'variables' => 'nullable|string',
            'greeting' => 'nullable|string',
            'content_text' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate JSON manually
        $variables = [];

        if ($request->filled('variables')) {
            $decoded = json_decode($request->variables, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'variables' => ['Variables must be valid JSON format.']
                    ]
                ], 422);
            }

            $variables = $decoded;
        }

        $validated = $validator->validated();
        
        $data = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'type' => $validated['type'],
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'variables' => $variables,
            'greeting' => $request->greeting ?? null,
            'content_text' => $request->content_text ?? null,
            'footer_text' => $request->footer_text ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($isUpdate) {
            $emailTemplate->update($data);
        } else {
            EmailTemplate::create($data);
        }

        return response()->json([
            'success' => true,
            'message' => $isUpdate ? 'Template updated successfully.' : 'Template created successfully.',
            'redirect' => route('email-templates.index')
        ]);
    }
}
