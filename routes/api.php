<?php

// routes/api.php
use App\Http\Controllers\DepartmentHeadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use NotificationChannels\WebPush\PushSubscription;

Route::middleware('web')->group(function () {
    Route::post('/switch-language', function (Request $request) {
        $request->validate([
            'language' => 'required|string|in:en,bn,ar,hi'
        ]);
        
        session(['locale' => $request->language]);
        
        // Update user preference if logged in
        if (Auth::check()) {
            Auth::user()->update(['preferred_language' => $request->language]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Language switched successfully',
            'language' => $request->language
        ]);
    });
    
    // Get all translations for current language
    Route::get('/translations/{group?}', function ($group = 'frontend') {
        $translationService = app(App\Services\TranslationService::class);
        return response()->json([
            'translations' => $translationService->getAll($group)
        ]);
    });
    
    // Get employees by department (for department head assignment)
    Route::get('/employees-by-department/{departmentId}', [DepartmentHeadController::class, 'getEmployeesByDepartment'])->name('api.employees-by-department');
    
    // Web Push Subscription Routes
    Route::post('/push/subscribe', function (Request $request) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate([
            'subscription' => 'required|array'
        ]);
        
        $user = Auth::user();
        
        // Find existing subscription or create new one
        $subscription = $user->pushSubscriptions()->where('endpoint', $request->subscription['endpoint'])->first();
        
        if (!$subscription) {
            $subscription = new PushSubscription();
            $subscription->user_id = $user->id;
            $subscription->endpoint = $request->subscription['endpoint'];
            $subscription->public_key = $request->subscription['keys']['p256dh'] ?? null;
            $subscription->auth_token = $request->subscription['keys']['auth'] ?? null;
            $subscription->save();
        }
        
        return response()->json(['success' => true]);
    });
    
    Route::post('/push/unsubscribe', function (Request $request) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate([
            'endpoint' => 'required|string'
        ]);
        
        $user = Auth::user();
        $user->pushSubscriptions()->where('endpoint', $request->endpoint)->delete();
        
        return response()->json(['success' => true]);
    });
});