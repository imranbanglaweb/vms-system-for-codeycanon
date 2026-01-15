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
            'features' => 'nullable|array'
        ]);

        $data['features'] = array_values(array_filter($data['features'] ?? []));

        SubscriptionPlan::create($data);

        return response()->json([
            'success' => true,
            'redirect' => route('admin.plans.index')
        ]);
    }


    public function edit(SubscriptionPlan $plan)
    {
        return view('admin.dashboard.plans.edit', compact('plan'));
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $plan->update($request->all());
        return redirect()->route('admin.dashboard.plans.index')->with('success','Plan updated');
    }

    // Public pricing page
      public function price()
    {
        // Fetch all active plans
        $plans = SubscriptionPlan::where('is_active', true)
                    ->orderBy('id', 'asc')
                    ->orderBy('price', 'asc')
                    ->get();

        // Pass to view
        return view('admin.dashboard.public.pricing', compact('plans'));
    }
}
