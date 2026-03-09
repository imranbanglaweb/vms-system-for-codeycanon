<?php

namespace App\Http\Controllers;

use App\Mail\GenericMailable;
use App\Models\EmailTemplate;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TestEmailController extends Controller
{
    /**
     * Show the test email form
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = EmailTemplate::where('is_active', true)->pluck('name', 'id');
        return view('admin.dashboard.email-templates.test', compact('templates'));
    }

    /**
     * Preview an email template
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_id' => 'nullable|exists:email_templates,id',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $subject = $request->subject ?? 'Test Email Preview';
            $body = $request->body ?? 'This is a test email preview.';

            // Get settings for dynamic branding
            $settings = Setting::first();
            $adminTitle = $settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০';
            $adminDescription = $settings && $settings->admin_description ? $settings->admin_description : 'All-in-One Fleet & Transport Automation System';
            // Generate absolute URL for logo - needed for emails
            $baseUrl = config('app.url', 'http://localhost');
            $logoUrl = $settings && $settings->admin_logo 
                ? $baseUrl . '/public/admin_resource/assets/images/' . $settings->admin_logo
                : null;
            $companyName = $adminTitle;

            // If template is selected, use template content
            if ($request->template_id) {
                $template = EmailTemplate::find($request->template_id);
                if ($template) {
                    $data = [
                        'name' => 'Test User',
                        'admin_title' => $adminTitle,
                        'admin_description' => $adminDescription,
                        'admin_logo_url' => $logoUrl ?: '',
                        'company_name' => $companyName,
                        'year' => date('Y'),
                    ];
                    $rendered = $template->render($data);
                    $subject = $rendered['subject'];
                    $body = $rendered['body'];
                }
            } else {
                // Replace variables in custom body
                $body = str_replace(
                    ['{{admin_title}}', '{{admin_description}}', '{{company_name}}', '{{year}}'],
                    [$adminTitle, $adminDescription, $companyName, date('Y')],
                    $body
                );
            }

            // Generate preview HTML
            $previewHtml = $this->generatePreviewHtml($subject, $body, $companyName, $logoUrl);

            return response()->json([
                'success' => true,
                'html' => $previewHtml,
                'subject' => $subject
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to generate email preview: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate preview: ' . $e->getMessage()
            ], 500);
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

    /**
     * Send a test email using a template
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_email' => 'required|email',
            'template_id' => 'nullable|exists:email_templates,id',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $email = $request->recipient_email;
            $subject = $request->subject ?? 'Test Email';
            $body = $request->body ?? 'This is a test email sent from the Transport Management System.';

            // If template is selected, use template content
            if ($request->template_id) {
                $template = EmailTemplate::find($request->template_id);
                if ($template) {
                    // Get settings for dynamic branding
                    $settings = Setting::first();
                    $adminTitle = $settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০';
                    $adminDescription = $settings && $settings->admin_description ? $settings->admin_description : 'All-in-One Fleet & Transport Automation System';
                    $logoUrl = $settings && $settings->admin_logo 
                        ? asset('public/admin_resource/assets/images/' . $settings->admin_logo) 
                        : null;
                    
                    $rendered = $template->render([
                        'name' => 'Test User',
                        'date' => now()->format('Y-m-d'),
                        'time' => now()->format('H:i:s'),
                        'admin_title' => $adminTitle,
                        'admin_description' => $adminDescription,
                        'admin_logo_url' => $logoUrl ?: '',
                        'company_name' => $adminTitle,
                        'year' => date('Y'),
                    ]);
                    $subject = $rendered['subject'];
                    $body = $rendered['body'];
                }
            }

            // Send the email
            Mail::to($email)->send(new GenericMailable($subject, $body));

            Log::info("Test email sent to {$email}", [
                'template_id' => $request->template_id,
                'subject' => $subject,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Test email sent successfully to {$email}"
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send test email: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send a simple test email without template
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendSimple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $email = $request->email;
            $settings = Setting::first();
            $companyName = $settings && $settings->admin_title ? $settings->admin_title : 'InayaFleet - 360';
            $subject = 'Test Email - ' . $companyName;
            $body = '
                <h2>Test Email</h2>
                <p>This is a test email to verify your email configuration is working correctly.</p>
                <p><strong>Sent at:</strong> ' . now()->format('Y-m-d H:i:s') . '</p>
                <p><strong>From:</strong> ' . config('mail.from.address') . '</p>
            ';

            Mail::to($email)->send(new GenericMailable($subject, $body));

            return response()->json([
                'success' => true,
                'message' => "Test email sent successfully to {$email}"
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send test email: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }
}
