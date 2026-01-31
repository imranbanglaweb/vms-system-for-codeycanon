<?php

namespace App\Http\Controllers;

use App\Mail\GenericMailable;
use App\Models\EmailTemplate;
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
     * Send a test email using a template
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
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
            $email = $request->email;
            $subject = $request->subject ?? 'Test Email';
            $body = $request->body ?? 'This is a test email sent from the Transport Management System.';

            // If template is selected, use template content
            if ($request->template_id) {
                $template = EmailTemplate::find($request->template_id);
                if ($template) {
                    $rendered = $template->render([
                        'name' => 'Test User',
                        'date' => now()->format('Y-m-d'),
                        'time' => now()->format('H:i:s'),
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
            $subject = 'Test Email - ' . config('app.name');
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
