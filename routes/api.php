<?php

// routes/api.php
use App\Http\Controllers\Api\PublicApiController;
use App\Http\Controllers\DepartmentHeadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use NotificationChannels\WebPush\PushSubscription;

// ============================================================================
// PUBLIC API ROUTES (For External Subscription System)
// ============================================================================

Route::middleware(['cors', 'api'])->group(function () {
    Route::post('/register', [PublicApiController::class, 'register']);
    Route::post('/login', [PublicApiController::class, 'login']);
    Route::post('/subscribe', [PublicApiController::class, 'subscribe']);
    Route::post('/submit-payment', [PublicApiController::class, 'submitPayment']);
    Route::get('/packages', [PublicApiController::class, 'packages']);
    Route::get('/packages/{id}', [PublicApiController::class, 'packageById']);
});

// ============================================================================
// GPS TRACKING API ROUTES (For Mobile App)
// ============================================================================

// Test route to verify API is working
Route::get('/test', function () {
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
            'language' => 'required|string|in:en,bn,ar,hi',
        ]);

        session(['locale' => $request->language]);

        // Update user preference if logged in
        if (Auth::check()) {
            Auth::user()->update(['preferred_language' => $request->language]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Language switched successfully',
            'language' => $request->language,
        ]);
    });

    // Get all translations for current language
    Route::get('/translations/{group?}', function ($group = 'frontend') {
        $translationService = app(App\Services\TranslationService::class);

        return response()->json([
            'translations' => $translationService->getAll($group),
        ]);
    });

    // Get employees by department (for department head assignment)
    Route::get('/employees-by-department/{departmentId}', [DepartmentHeadController::class, 'getEmployeesByDepartment'])->name('api.employees-by-department');

    // Web Push Subscription Routes
    Route::post('/push/subscribe', function (Request $request) {
        if (! Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'subscription' => 'required|array',
        ]);

        $user = Auth::user();

        // Find existing subscription or create new one
        $subscription = $user->pushSubscriptions()->where('endpoint', $request->subscription['endpoint'])->first();

        if (! $subscription) {
            $subscription = new PushSubscription;
            $subscription->user_id = $user->id;
            $subscription->endpoint = $request->subscription['endpoint'];
            $subscription->public_key = $request->subscription['keys']['p256dh'] ?? null;
            $subscription->auth_token = $request->subscription['keys']['auth'] ?? null;
            $subscription->save();
        }

        return response()->json(['success' => true]);
    });

    Route::post('/push/unsubscribe', function (Request $request) {
        if (! Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'endpoint' => 'required|string',
        ]);

        $user = Auth::user();
        $user->pushSubscriptions()->where('endpoint', $request->endpoint)->delete();

        return response()->json(['success' => true]);
    });
});

// ============================================================================
// DRIVER MOBILE APP API ROUTES
// ============================================================================

Route::prefix('driver')->middleware('auth:api')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DriverController::class, 'driverDashboard']);

    // Trips
    Route::get('/trips', [App\Http\Controllers\DriverController::class, 'driverTrips']);
    Route::get('/trips/{id}', [App\Http\Controllers\DriverController::class, 'driverTripStatus']);
    Route::post('/trips/{id}/start', [App\Http\Controllers\DriverController::class, 'startTrip']);
    Route::post('/trips/{id}/finish', [App\Http\Controllers\DriverController::class, 'finishTrip']);
    Route::post('/trips/{id}/end', [App\Http\Controllers\DriverController::class, 'endTrip']);

    // Schedule
    Route::get('/schedule', [App\Http\Controllers\DriverController::class, 'driverSchedule']);

    // Fuel Log
    Route::get('/fuel-log', [App\Http\Controllers\DriverController::class, 'driverFuelLog']);
    Route::post('/fuel-log', [App\Http\Controllers\DriverController::class, 'storeFuelLog']);
    Route::get('/fuel-log/vehicle-data', [App\Http\Controllers\DriverController::class, 'getVehicleFuelData']);

    // Vehicle
    Route::get('/vehicle', [App\Http\Controllers\DriverController::class, 'driverVehicle']);

    // Availability
    Route::get('/availability', [App\Http\Controllers\DriverController::class, 'driverAvailability']);
    Route::post('/availability', [App\Http\Controllers\DriverController::class, 'updateAvailability']);

    // Profile
    Route::get('/profile', [App\Http\Controllers\DriverController::class, 'driverProfile']);
});

// ============================================================================
// AUTHENTICATION ROUTES FOR MOBILE APP
// ============================================================================

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'apiLogin']);

// ============================================================================
// PUBLIC SETTINGS ROUTES (For Mobile App)
// ============================================================================

Route::get('/settings', function () {
    $settings = DB::table('settings')->where('id', 1)->first();

    $logoUrl = null;
    if ($settings && $settings->admin_logo) {
        $logoUrl = asset('public/admin_resource/assets/images/'.$settings->admin_logo);
    }

    return response()->json([
        'logo_url' => $logoUrl,
        'title' => $settings->admin_title ?? 'গাড়িবন্ধু ৩৬০',
        'description' => $settings->admin_description ?? 'Fleet Management Solution',
    ]);
});
