<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    protected $stripeService;

    public function __construct(StripePaymentService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Show plan selection page
     */
    public function select($slug)
    {
        $plan = SubscriptionPlan::where('slug', $slug)->firstOrFail();
        return view('admin.dashboard.public.subscribe', compact('plan'));
    }

    /**
     * Create subscription with Stripe
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_method_id' => 'nullable|string',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $company = Company::where('id', Auth::user()->company_id)->firstOrFail();

        // Create Stripe subscription
        $result = $this->stripeService->createSubscription($company, $plan);

        if (!$result['success']) {
            return back()->withErrors(['error' => $result['error']]);
        }

        return redirect()->route('subscription.confirmation', [
            'subscription_id' => $result['subscription']->id,
            'client_secret' => $result['client_secret'],
        ]);
    }

    /**
     * Show subscription confirmation page
     */
    public function confirmation(Request $request)
    {
        $subscription = Subscription::with(['plan', 'company'])
            ->where('id', $request->subscription_id)
            ->where('company_id', Auth::user()->company_id)
            ->firstOrFail();

        return view('admin.dashboard.public.subscription-confirmation', [
            'subscription' => $subscription,
            'client_secret' => $request->client_secret,
        ]);
    }

    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'cancel_immediately' => 'boolean',
        ]);

        $subscription = Subscription::where('id', $request->subscription_id)
            ->where('company_id', Auth::user()->company_id)
            ->firstOrFail();

        $result = $this->stripeService->cancelSubscription(
            $subscription,
            $request->boolean('cancel_immediately', false)
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['error'],
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Subscription cancelled successfully',
        ]);
    }

    /**
     * Change subscription plan
     */
    public function changePlan(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'new_plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $subscription = Subscription::where('id', $request->subscription_id)
            ->where('company_id', Auth::user()->company_id)
            ->firstOrFail();

        $newPlan = SubscriptionPlan::findOrFail($request->new_plan_id);

        $result = $this->stripeService->changePlan($subscription, $newPlan);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['error'],
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Plan changed successfully',
        ]);
    }

    /**
     * Get subscription details
     */
    public function show()
    {
        $company = Company::where('id', Auth::user()->company_id)->firstOrFail();

        $subscription = $company->subscription()->with('plan')->first();

        if (!$subscription) {
            return response()->json(['error' => 'No active subscription'], 404);
        }

        return response()->json([
            'subscription' => $subscription,
            'payment_methods' => $this->stripeService->getPaymentMethods($company),
        ]);
    }
}

