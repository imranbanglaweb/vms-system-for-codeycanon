<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::latest()->orderBy('name', 'asc')->get();
        return view('admin.dashboard.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.dashboard.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|unique:subscription_plans,slug',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'vehicle_limit' => 'nullable|integer',
            'user_limit' => 'nullable|integer',
            'driver_limit' => 'nullable|integer',
            'monthly_reports' => 'nullable|integer',
            'monthly_alerts' => 'nullable|integer',
            'features' => 'nullable|array',
            'is_popular' => 'nullable',
            'is_active' => 'nullable',
            'is_trial' => 'nullable',
            'trial_days' => 'nullable|integer',
            'recommended_for' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer',
        ]);

        $data['features'] = array_values(array_filter($data['features'] ?? []));
        $data['is_popular'] = $request->has('is_popular') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['is_trial'] = $request->has('is_trial') ? 1 : 0;
        $data['last_updated_at'] = now();
        $data['display_order'] = $data['display_order'] ?? 0;

        SubscriptionPlan::create($data);

        return response()->json([
            'success' => true,
            'redirect' => route('admin.dashboard.plans.index')
        ]);
    }


    public function edit(SubscriptionPlan $plan)
    {
        return view('admin.dashboard.plans.edit', compact('plan'));
    }

    public function show(SubscriptionPlan $plan)
    {
        return view('admin.dashboard.plans.show', compact('plan'));
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|unique:subscription_plans,slug,' . $plan->id,
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'vehicle_limit' => 'nullable|integer',
            'user_limit' => 'nullable|integer',
            'driver_limit' => 'nullable|integer',
            'monthly_reports' => 'nullable|integer',
            'monthly_alerts' => 'nullable|integer',
            'features' => 'nullable|array',
            'is_popular' => 'nullable',
            'is_active' => 'nullable',
            'is_trial' => 'nullable',
            'trial_days' => 'nullable|integer',
            'recommended_for' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer',
        ]);

        $data['features'] = array_values(array_filter($data['features'] ?? []));
        $data['is_popular'] = $request->has('is_popular') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['is_trial'] = $request->has('is_trial') ? 1 : 0;
        $data['last_updated_at'] = now();
        $data['display_order'] = $data['display_order'] ?? 0;

        $plan->update($data);

        return response()->json([
            'success' => true,
            'redirect' => route('admin.dashboard.plans.index')
        ]);
    }

    // Public pricing page
      public function price()
    {
        $plans = SubscriptionPlan::where('is_active', true)
                    ->orderBy('display_order', 'asc')
                    ->orderBy('price', 'asc')
                    ->get();

        return view('admin.dashboard.public.pricing', compact('plans'));
    }
}
