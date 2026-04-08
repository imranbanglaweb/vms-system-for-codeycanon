<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Demo login for quick login as different user roles
     */
    public function demoLogin(Request $request)
    {
        $email = $request->input('email');
        
        $user = \App\Models\User::where('email', $email)->first();
        
        if ($user) {
            Auth::login($user);
            return redirect()->route('home');
        }
        
        return redirect()->route('login')->with('error', 'Demo account not found');
    }

    /**
     * API Login for mobile app - returns JWT token
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Create personal access token
            $token = $user->createToken('driver-app')->plainTextToken;

            // Get driver profile - try multiple methods
            $driver = null;
            
            // Method 1: Find by employee_id relationship
            $employee = \App\Models\Employee::where('email', $user->email)->first();
            if ($employee) {
                $driver = \App\Models\Driver::where('employee_id', $employee->id)->first();
            }
            
            // Method 2: Fallback - find by matching name or phone
            if (!$driver) {
                $driver = \App\Models\Driver::where('driver_name', $user->name)->first();
            }
            
            // Method 3: Fallback - find by mobile if cell_phone matches
            if (!$driver && $user->cell_phone) {
                $driver = \App\Models\Driver::where('mobile', $user->cell_phone)->first();
            }

            return response()->json([
                'success' => true,
                'token' => $token,
                'driver' => $driver ? [
                    'id' => $driver->id,
                    'driver_name' => $driver->driver_name,
                    'license_number' => $driver->license_number,
                    'license_type' => $driver->license_type,
                    'mobile' => $driver->mobile,
                    'nid' => $driver->nid,
                    'present_address' => $driver->present_address,
                    'permanent_address' => $driver->permanent_address,
                    'photograph' => $driver->photograph,
                    'availability_status' => $driver->availability_status,
                    'availability_notes' => $driver->availability_notes,
                    'available_from' => $driver->available_from,
                    'available_until' => $driver->available_until,
                ] : null,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }
}
