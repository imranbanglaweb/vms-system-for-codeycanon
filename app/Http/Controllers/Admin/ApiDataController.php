<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ApiDataController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('type') && $request->type === 'users') {
            return $this->getUsers($request);
        }
        
        if ($request->has('type') && $request->type === 'pending') {
            return $this->getPendingPayments($request);
        }

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

        return view('admin.dashboard.plans.subscriptions.api-data');
    }

    public function getUsers(Request $request)
    {
        $users = User::with(['company', 'employee'])
            ->whereNotNull('company_id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function getPendingPayments(Request $request)
    {
        $payments = Payment::with(['company', 'plan', 'subscription'])
            ->where('status', 'pending')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }
}