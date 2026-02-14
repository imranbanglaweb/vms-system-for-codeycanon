<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PushSubscription;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushTestController extends Controller
{
    public function __construct()
    {
        // Set OpenSSL config path for Windows XAMPP - must be done before any OpenSSL operations
        $opensslPath = 'F:/xampp php8/apache/conf/openssl.cnf';
        if (PHP_OS === 'WINNT' && file_exists($opensslPath)) {
            putenv('OPENSSL_CONF=' . $opensslPath);
            $_ENV['OPENSSL_CONF'] = $opensslPath;
        }
    }

    public function send(Request $request)
    {
        try {
            // Re-apply OpenSSL config in case it wasn't set in constructor
            $opensslPath = 'F:/xampp php8/apache/conf/openssl.cnf';
            if (PHP_OS === 'WINNT' && file_exists($opensslPath)) {
                putenv('OPENSSL_CONF=' . $opensslPath);
                $_ENV['OPENSSL_CONF'] = $opensslPath;
            }

            $request->validate([
                'user_id' => 'nullable|exists:users,id',
            ]);

            $query = PushSubscription::query();

            if ($request->user_id) {
                $query->where('user_id', $request->user_id);
            }

            $subscriptions = $query->get();

            if ($subscriptions->isEmpty()) {
                return response()->json([
                    'message' => 'No subscriptions found. Please subscribe to push notifications first.',
                    'subscriptions_count' => 0
                ], 404);
            }

            $webPush = new WebPush([
                'VAPID' => [
                    'subject' => config('webpush.vapid.subject'),
                    'publicKey' => config('webpush.vapid.public_key'),
                    'privateKey' => config('webpush.vapid.private_key'),
                ],
            ]);

            $successCount = 0;
            $failedCount = 0;
            $errors = [];

            foreach ($subscriptions as $sub) {
                // Determine content encoding - FCM uses aesgcm, others use aes128gcm
                $contentEncoding = $sub->content_encoding;
                
                if (empty($contentEncoding)) {
                    // Default to aesgcm for FCM endpoints, aes128gcm for others
                    if (strpos($sub->endpoint, 'fcm.googleapis.com') !== false) {
                        $contentEncoding = 'aesgcm';
                    } else {
                        $contentEncoding = 'aes128gcm';
                    }
                }

                try {
                    $subscription = Subscription::create([
                        'endpoint' => $sub->endpoint,
                        'publicKey' => $sub->public_key,
                        'authToken' => $sub->auth_token,
                        'contentEncoding' => $contentEncoding,
                    ]);

                    $payload = json_encode([
                        'title' => 'Test Notification',
                        'body'  => 'This is a test push notification from InayaFleet360 🔔',
                        'icon'  => '/admin_resource/assets/images/icons.png',
                        'data' => ['url' => '/admin/dashboard']
                    ]);

                    $report = $webPush->sendOneNotification($subscription, $payload);

                    if ($report->isSuccess()) {
                        $successCount++;
                    } else {
                        $failedCount++;
                        $reason = $report->getReasonPhrase();
                        $endpoint = $sub->endpoint;
                        
                        // Try to get more details from the report
                        $errorMsg = $reason;
                        if (method_exists($report, 'getResponse')) {
                            $response = $report->getResponse();
                            if ($response) {
                                $errorMsg .= ' - Status: ' . $response->getStatusCode();
                                $body = (string) $response->getBody();
                                $errorMsg .= ' - Body: ' . $body;
                            }
                        }
                        
                        $errors[] = [
                            'endpoint' => substr($endpoint, 0, 50) . '...',
                            'reason' => $errorMsg
                        ];
                        \Log::error('Push notification failed for user ' . $sub->user_id . ': ' . $errorMsg);
                    }
                } catch (\Exception $e) {
                    $failedCount++;
                    $errors[] = [
                        'endpoint' => substr($sub->endpoint, 0, 50) . '...',
                        'reason' => $e->getMessage()
                    ];
                    \Log::error('Push notification exception: ' . $e->getMessage());
                }
            }

            return response()->json([
                'message' => 'Push notification processed',
                'subscriptions_count' => $subscriptions->count(),
                'success_count' => $successCount,
                'failed_count' => $failedCount,
                'errors' => $errors,
                'note' => 'If notifications are not received, users may need to re-subscribe with the correct VAPID key.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error sending notification',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
