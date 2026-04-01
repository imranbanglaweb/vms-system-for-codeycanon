<?php

// routes/api.php
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\GpsTrackingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use NotificationChannels\WebPush\PushSubscription;

// ============================================================================
// GPS TRACKING API ROUTES (For Mobile App)
// ============================================================================

// Test route to verify API is working
Route::get('/test', function() {
    return response()->json(['status' => 'ok', 'message' => 'API is working']);
});

Route::prefix('gps')->group(function () {
    // Device registration
    Route::post('/device/register', 'GpsTrackingController@registerDevice');
    
    // Single GPS point upload
    Route::post('/track', 'GpsTrackingController@storeGpsData');
    
    // Batch GPS data upload
    Route::post('/batch', 'GpsTrackingController@storeBatchGpsData');
    
    // Get live tracking for all vehicles
    Route::get('/live', 'GpsTrackingController@getLiveTracking');
    
    // Get single vehicle tracking
    Route::get('/vehicle/{id}', 'GpsTrackingController@getVehicleTracking');
    
    // Get tracking history
    Route::get('/history/{vehicleId}', 'GpsTrackingController@getTrackingHistory');
    
    // Get active trips with live tracking
    Route::get('/active-trips', 'GpsTrackingController@getActiveTrips');
    
    // Get GPS status
    Route::get('/status', 'GpsTrackingController@getStatus');
});

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