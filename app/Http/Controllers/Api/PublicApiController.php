<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PublicApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cell_phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->cell_phone,
                ]
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $token
            ]
        ]);
    }

    public function packages()
    {
        $packages = SubscriptionPlan::where('is_active', true)
            ->orderBy('display_order')
            ->get(['id', 'name', 'price', 'billing_cycle', 'vehicle_limit', 'user_limit', 'driver_limit']);

        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    }

    public function packageById($id)
    {
        $package = SubscriptionPlan::find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $package
        ]);
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_id' => 'required|exists:subscription_plans,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $plan = SubscriptionPlan::find($request->package_id);
        
        $user = User::where('email', $request->customer_email)->first();
        
        if (!$user) {
            $user = User::create([
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'cell_phone' => $request->customer_phone,
                'password' => Hash::make(Str::random(10)),
            ]);
        }

        $company = Company::create([
            'name' => $request->customer_name . ' Company',
            'email' => $request->customer_email,
            'phone' => $request->customer_phone,
        ]);

        $user->company_id = $company->id;
        $user->save();

        $subscription = Subscription::create([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'plan_id' => $request->package_id,
            'starts_at' => now(),
            'ends_at' => $plan->is_trial 
                ? now()->addDays($plan->trial_days ?? 7) 
                : now()->addDays(30),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully',
            'data' => [
                'subscription_id' => $subscription->id,
                'plan' => $plan->name,
                'amount' => $plan->price,
                'status' => $subscription->status
            ]
        ], 201);
    }

    public function submitPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subscription_id' => 'required|exists:subscriptions,id',
            'payment_method' => 'required|string',
            'transaction_id' => 'required|string',
            'sender_number' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $subscription = Subscription::with(['company', 'plan'])->find($request->subscription_id);
        
        $payment = Payment::create([
            'company_id' => $subscription->company_id,
            'user_id' => $subscription->user_id,
            'subscription_id' => $subscription->id,
            'plan_id' => $subscription->plan_id,
            'method' => $request->payment_method,
            'amount' => $request->amount,
            'currency' => 'BDT',
            'transaction_id' => $request->transaction_id,
            'sender_number' => $request->sender_number,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment submitted successfully',
            'data' => [
                'payment_id' => $payment->id,
                'subscription_id' => $subscription->id,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'transaction_id' => $payment->transaction_id
            ]
        ], 201);
    }
}