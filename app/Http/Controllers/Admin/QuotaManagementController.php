<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SubscriptionPlan;
use App\Services\QuotaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class QuotaManagementController extends Controller
{
    protected $quotaService;

    public function __construct(QuotaService $quotaService)
    {
        $this->quotaService = $quotaService;
    }

    public function index(Request $request)
    {
        $companies = Company::with(['subscription', 'subscription.plan'])
            ->latest()
            ->paginate(15);

        return view('admin.dashboard.quota-management.index', compact('companies'));
    }

    public function show(Company $company)
    {
        $company->load(['subscription.plan', 'subscription.plan']);
        
        $stats = $this->quotaService->getUsageStats($company);
        $alerts = $this->quotaService->getQuotaAlerts($company);
        
        return view('admin.dashboard.quota-management.show', compact('company', 'stats', 'alerts'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'vehicle_limit' => 'nullable|integer|min:0',
            'user_limit' => 'nullable|integer|min:0',
            'driver_limit' => 'nullable|integer|min:0',
            'monthly_reports' => 'nullable|integer|min:0',
            'monthly_alerts' => 'nullable|integer|min:0',
        ]);

        $subscription = $company->subscription;
        
        if ($subscription && $subscription->plan) {
            $plan = $subscription->plan;
            
            $plan->vehicle_limit = $validated['vehicle_limit'] ?? $plan->vehicle_limit;
            $plan->user_limit = $validated['user_limit'] ?? $plan->user_limit;
            $plan->driver_limit = $validated['driver_limit'] ?? $plan->driver_limit;
            $plan->monthly_reports = $validated['monthly_reports'] ?? $plan->monthly_reports;
            $plan->monthly_alerts = $validated['monthly_alerts'] ?? $plan->monthly_alerts;
            $plan->save();

            $this->quotaService->clearUsageCache($company);
        }

        return redirect()->route('admin.quota-management.index')
            ->with('success', 'Quota updated successfully for ' . $company->company_name);
    }

    public function assignPlan(Request $request, Company $company)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $plan = SubscriptionPlan::findOrFail($validated['plan_id']);
        
        $subscription = $company->subscription;
        
        if ($subscription) {
            $subscription->plan_id = $plan->id;
            $subscription->save();
        } else {
            $company->subscription()->create([
                'plan_id' => $plan->id,
                'status' => 'active',
                'starts_at' => now(),
            ]);
        }

        $this->quotaService->clearUsageCache($company);

        return redirect()->route('admin.quota-management.index')
            ->with('success', 'Plan assigned successfully to ' . $company->company_name);
    }

    public function clearCache(Company $company)
    {
        $this->quotaService->clearUsageCache($company);

        return redirect()->back()
            ->with('success', 'Cache cleared for ' . $company->company_name);
    }

    public function search(Request $request)
    {
        $search = $request->get('search', '');
        
        $companies = Company::with(['subscription', 'subscription.plan'])
            ->where('company_name', 'like', "%{$search}%")
            ->orWhere('company_code', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->paginate(15);

        return view('admin.dashboard.quota-management.index', compact('companies', 'search'));
    }
}
