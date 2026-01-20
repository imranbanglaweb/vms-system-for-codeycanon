<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PushSubscription;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushTestController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
        ]);

        $query = PushSubscription::query();

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $subscriptions = $query->get();

        if ($subscriptions->isEmpty()) {
            return response()->json(['message' => 'No subscriptions found'], 404);
        }

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => config('webpush.vapid.subject'),
                'publicKey' => config('webpush.vapid.public_key'),
                'privateKey' => config('webpush.vapid.private_key'),
            ],
        ]);

        foreach ($subscriptions as $sub) {
            $subscription = Subscription::create([
                'endpoint' => $sub->endpoint,
                'publicKey' => $sub->public_key,
                'authToken' => $sub->auth_token,
                'contentEncoding' => $sub->content_encoding,
            ]);

            $webPush->sendOneNotification(
                $subscription,
                json_encode([
                    'title' => 'Test Notification',
                    'body'  => 'This is a test push notification 🔔',
                    'icon'  => '/icon-192.png',
                ])
            );
        }

        return response()->json(['message' => 'Test notification sent']);
    }
}
