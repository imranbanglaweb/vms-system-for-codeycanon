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
                // Determine content encoding - Modern browsers use aes128gcm, older ones use aesgcm
                $contentEncoding = $sub->content_encoding;
                
                if (empty($contentEncoding)) {
                    // Default to aes128gcm for all endpoints (modern standard)
                    $contentEncoding = 'aes128gcm';
                }

                try {
                    \Log::info('Creating subscription with encoding: ' . $contentEncoding);
                    \Log::info('Endpoint: ' . $sub->endpoint);
                    \Log::info('Public key: ' . $sub->public_key);
                    
                    $subscription = Subscription::create([
                        'endpoint' => $sub->endpoint,
                        'publicKey' => $sub->public_key,
                        'authToken' => $sub->auth_token,
                        'contentEncoding' => $contentEncoding,
                    ]);

                    $payload = json_encode([
                        'title' => 'Test Notification',
                        'body'  => 'This is a test push notification from গাড়িবন্ধু ৩৬০ 🔔',
                        'icon'  => '/admin_resource/assets/images/icons.png',
                        'data' => ['url' => '/admin/dashboard']
                    ]);

                    \Log::info('Sending notification to: ' . $sub->endpoint);
                    $report = $webPush->sendOneNotification($subscription, $payload);
                    \Log::info('Report isSuccess: ' . ($report->isSuccess() ? 'yes' : 'no'));

                    if ($report->isSuccess()) {
                        $successCount++;
                    } else {
                        $failedCount++;
                        $reason = $report->getReasonPhrase();
                        \Log::error('Push failed reason: ' . $reason);
                        $errors[] = [
                            'endpoint' => substr($sub->endpoint, 0, 50) . '...',
                            'reason' => $reason
                        ];
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

    /**
     * Clear all push subscriptions (admin function to fix key mismatches)
     */
    public function clearAllSubscriptions()
    {
        try {
            // Set OpenSSL config for Windows
            $opensslPath = 'F:/xampp php8/apache/conf/openssl.cnf';
            if (PHP_OS === 'WINNT' && file_exists($opensslPath)) {
                putenv('OPENSSL_CONF=' . $opensslPath);
                $_ENV['OPENSSL_CONF'] = $opensslPath;
            }

            // Use the custom PushSubscription model
            $count = \App\Models\PushSubscription::count();
            \App\Models\PushSubscription::truncate();

            return response()->json([
                'success' => true,
                'message' => "Cleared {$count} push subscriptions. Users need to re-subscribe with the new VAPID key.",
                'cleared_count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing subscriptions',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
