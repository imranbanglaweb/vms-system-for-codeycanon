<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Payment;
use Illuminate\Http\Request;
use PDF;

class ManualPaymentController extends Controller
{
    public function form($planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        return view('admin.dashboard.plans.manual', compact('plan'));
    }

    public function ajaxStore(Request $request)
    {

        $request->validate([
                'plan_id' => 'required|exists:subscription_plans,id',
                'trx_id'  => 'required',
                'amount'  => 'required|numeric'
            ]);
            
            // return dd($request);

        // dd($plan->id);

        // Subscription::create([
        //     // 'company_id' => auth()->user()->company_id ?? 1,
        //     'user_id' => auth()->id(),
        //     'plan_id' => $plan->id,
        //     'status' => 'pending',
        //     'payment_method' => 'manual',
        // ]);

        Subscription::create([
            'user_id' => auth()->id(),
            'plan_id'  => $request->plan_id,
            'starts_at' => now(),
            'ends_at' => now()->addDays($plan->duration_days),
            'status' => 'pending',
            'payment_method' => 'manual',
            'is_locked' => 1,
        ]);

        // $payment = Payment::create([
        //     'user_id' => auth()->id(),
        //     'subscription_id' => $subscription->id,
        //     'amount' => $request->amount,
        //     'trx_id' => $request->trx_id,
        //     'method' => 'manual',
        //     'status' => 'pending',
        // ]);

        return response()->json([
            'success' => true,
            'invoice_url' => route('invoice.download', $payment->id)
        ]);
    }

    public function invoice(Payment $payment)
    {
        $pdf = PDF::loadView('admin.dashboard.invoice.pdf', compact('payment'))
                    ->setPaper('A4');

        return $pdf->download('invoice-'.$payment->id.'.pdf');
    }
}
