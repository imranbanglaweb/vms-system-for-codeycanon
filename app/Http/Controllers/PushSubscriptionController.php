<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use NotificationChannels\WebPush\PushSubscription;
use App\Models\PushSubscription;
use App\Models\User;
class PushSubscriptionController extends Controller
{

     public function index()
    {
        // $users = User::whereNotNull('push_subscription')
        //     ->orderBy('updated_at', 'desc')
        //     ->get();
        $subscriptions = PushSubscription::with('user')
        ->latest()
        ->get();

        return view('admin.dashboard.settings.subscribers', compact('subscriptions'));
    }
    public function store(Request $request)
    {
        $user = Auth::user();

        $user->updatePushSubscription(
            $request->endpoint,
            $request->keys['p256dh'],
            $request->keys['auth']
        );

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $user->pushSubscriptions()->where('endpoint', $request->endpoint)->delete();

        return response()->json(['success' => true]);
    }
}
