<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PushSubscription;
class PushSubscriptionController extends Controller
{
    /**
     * Store the Push Subscription.
     */
    public function index()
    {
          $subscriptions = PushSubscription::with('user')
        ->latest()
        ->get();
          return view('admin.dashboard.settings.subscribers', compact('subscriptions'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);

        $user = Auth::user();
        
        $user->updatePushSubscription(
            $request->endpoint,
            $request->keys['p256dh'],
            $request->keys['auth']
        );

        return response()->json(['success' => true], 200);
    }

    /**
     * Remove the Push Subscription.
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required'
        ]);

        $user = Auth::user();
        
        $user->deletePushSubscription($request->endpoint);

        return response()->json(['success' => true], 200);
    }

    
}