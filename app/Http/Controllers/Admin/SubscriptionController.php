<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function select($slug)
    {
        $plan = SubscriptionPlan::where('slug', $slug)->firstOrFail();
        return view('admin.dashboard.public.subscribe', compact('plan'));
    }

    public function store(Request $request)
    {
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        Subscription::create([
            'company_id' => auth()->user()->company_id,
            'plan_id'    => $plan->id,
            'start_date' => now(),
            'end_date'   => $plan->billing_cycle === 'yearly'
                            ? now()->addYear()
                            : now()->addMonth(),
            'status'     => 'active'
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Subscription activated successfully');
    }
}

