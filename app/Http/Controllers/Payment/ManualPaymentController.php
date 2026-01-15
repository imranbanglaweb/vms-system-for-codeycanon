<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ManualPaymentController extends Controller
{
    /**
     * Show manual payment form
     */
    public function form($planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        return view('admin.dashboard.plans.manual', compact('plan'));
    }

    /**
     * Store manual payment request (AJAX)
     */
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'trx_id'  => 'required|string',
            'amount'  => 'required|numeric|min:1',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        // dd($plan->id);

        DB::beginTransaction();

        try {
            /**
             * 1️⃣ Create PENDING subscription
             */
            $subscription = Subscription::create([
                'company_id'      => auth()->user()->company_id ?? 1,
                'user_id'         => auth()->id(),
                'plan_id'         => $plan->id,
                'starts_at'       => null,
                'ends_at'         => null,
                'status'          => 'pending',
                'payment_method'  => 'manual',
                'transaction_ref' => $request->trx_id,
            ]);

            /**
             * 2️⃣ Create PENDING payment
             */
            $payment = Payment::create([
                 'company_id'      => auth()->user()->company_id ?? 1,
                'user_id'         => auth()->id(),
                'subscription_id' => $subscription->id,
                'plan_id'         => $plan->id,
                'method'          => 'manual',
                'amount'          => $request->amount,
                'currency'        => 'BDT',
                'transaction_id'  => $request->trx_id,
                'status'          => 'pending',
                'created_by'      => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'success'     => true,
                'message'     => 'Manual payment request submitted successfully',
                'invoice_url' => route('invoice.download', $payment->id),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'error'   => $e->getMessage(), // remove in production
            ], 500);
        }
    }

    /**
     * Download invoice
     */
    public function invoice(Payment $payment)
    {
        $payment->load([
            'subscription.plan',
            'company',
            'user',
        ]);

        $pdf = PDF::loadView(
            'admin.dashboard.plans.subscriptions.payments.invoice.pdf',
            compact('payment')
        )->setPaper('A4');

        return $pdf->download('invoice-'.$payment->id.'.pdf');
    }
}
