<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Payment;
use App\Models\Subscription;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ApiPaymentController extends Controller
{
    public function registeredUsers(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with(['company', 'employee'])
                ->whereNotNull('company_id')
                ->select('users.*');

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('name', fn($u) => $u->name)
                ->addColumn('email', fn($u) => $u->email)
                ->addColumn('phone', fn($u) => $u->cell_phone ?? 'N/A')
                ->addColumn('company', fn($u) => $u->company->name ?? 'N/A')
                ->addColumn('joined_at', fn($u) => $u->created_at->format('d M Y'))
                ->addColumn('status', fn($u) => 
                    '<span class="badge bg-success">Active</span>'
                )
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('admin.dashboard.plans.subscriptions.api-users');
    }

    public function pendingPayments(Request $request)
    {
        if ($request->ajax()) {
            $payments = Payment::with(['company', 'plan', 'subscription'])
                ->where('status', 'pending');

            return DataTables::of($payments)
                ->addIndexColumn()
                ->addColumn('company', fn($p) => $p->company->name ?? 'N/A')
                ->addColumn('customer', fn($p) => $p->subscription && $p->subscription->user 
                    ? $p->subscription->user->name . '<br><small>' . $p->subscription->user->email . '</small>' 
                    : 'N/A')
                ->addColumn('plan', fn($p) => $p->plan ? $p->plan->name : 'N/A')
                ->addColumn('amount', fn($p) => number_format($p->amount, 2))
                ->addColumn('method', fn($p) => '<span class="badge bg-info text-dark">' . strtoupper($p->method) . '</span>')
                ->addColumn('transaction_id', fn($p) => $p->transaction_id ?? 'N/A')
                ->addColumn('sender_number', fn($p) => $p->sender_number ?? 'N/A')
                ->addColumn('created_at', fn($p) => $p->created_at->format('d M Y H:i'))
                ->addColumn('action', fn($p) => '
                    <button class="btn btn-success btn-sm approveBtn" data-id="'.$p->id.'">
                        <i class="fa fa-check"></i>
                    </button>
                    <button class="btn btn-danger btn-sm rejectBtn" data-id="'.$p->id.'">
                        <i class="fa fa-times"></i>
                    </button>
                ')
                ->rawColumns(['customer', 'method', 'action'])
                ->make(true);
        }

        return view('admin.dashboard.plans.subscriptions.api-payments-pending');
    }

    public function paidPayments(Request $request)
    {
        if ($request->ajax()) {
            $payments = Payment::with(['company', 'plan', 'subscription'])
                ->where('status', 'paid');

            return DataTables::of($payments)
                ->addIndexColumn()
                ->addColumn('company', fn($p) => $p->company->name ?? 'N/A')
                ->addColumn('customer', fn($p) => $p->subscription && $p->subscription->user 
                    ? $p->subscription->user->name . '<br><small>' . $p->subscription->user->email . '</small>' 
                    : 'N/A')
                ->addColumn('plan', fn($p) => $p->plan ? $p->plan->name : 'N/A')
                ->addColumn('amount', fn($p) => number_format($p->amount, 2))
                ->addColumn('method', fn($p) => '<span class="badge bg-success">' . strtoupper($p->method) . '</span>')
                ->addColumn('transaction_id', fn($p) => $p->transaction_id ?? 'N/A')
                ->addColumn('paid_at', fn($p) => $p->paid_at ? $p->paid_at->format('d M Y H:i') : $p->updated_at->format('d M Y'))
                ->rawColumns(['customer', 'method'])
                ->make(true);
        }

        return view('admin.dashboard.plans.subscriptions.api-payments-paid');
    }

    public function approvePayment(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Payment already processed'
            ], 422);
        }

        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        if ($payment->subscription) {
            $plan = $payment->plan;
            $duration = $plan && $plan->is_trial ? ($plan->trial_days ?? 7) : 30;
            
            $payment->subscription->update([
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addDays($duration),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment approved successfully'
        ]);
    }

    public function rejectPayment(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Payment already processed'
            ], 422);
        }

        $payment->update([
            'status' => 'rejected'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment rejected successfully'
        ]);
    }
}