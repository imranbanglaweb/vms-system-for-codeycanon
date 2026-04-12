<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ApiDataController extends Controller
{
    protected $apiBaseUrl = 'http://localhost/garibondhu360/backend/public/api';
    protected $apiToken = '2|dSn5j6TDZlDsqyovygCwsliz5OcrLazozRBjMeJz94106c4f';

    public function index(Request $request)
    {
        if ($request->has('type') && $request->type === 'users') {
            return $this->getUsers($request);
        }
        
        if ($request->has('type') && $request->type === 'pending') {
            return $this->getPendingPaymentsDataTable($request);
        }

        if ($request->ajax()) {
            return $this->getUsersDataTable($request);
        }

        return view('admin.dashboard.plans.subscriptions.api-data');
    }

    protected function getUsersDataTable(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ])->get($this->apiBaseUrl . '/users');

            if ($response->successful()) {
                $users = $response->json('data') ?? [];
                
                return DataTables::of(collect($users))
                    ->addIndexColumn()
                    ->addColumn('name', fn($u) => $u['name'] ?? 'N/A')
                    ->addColumn('email', fn($u) => $u['email'] ?? 'N/A')
                    ->addColumn('phone', fn($u) => $u['cell_phone'] ?? $u['phone'] ?? 'N/A')
                    ->addColumn('company', fn($u) => $u['company']['name'] ?? $u['company_name'] ?? 'N/A')
                    ->addColumn('joined_at', fn($u) => isset($u['created_at']) ? Carbon::parse($u['created_at'])->format('d M Y') : 'N/A')
                    ->addColumn('status', fn($u) => '<span class="badge bg-success">Active</span>')
                    ->rawColumns(['status'])
                    ->make(true);
            }
            
            return DataTables::of(collect([]))->make(true);
        } catch (\Exception $e) {
            return DataTables::of(collect([]))->make(true);
        }
    }

    protected function getPendingPaymentsDataTable(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ])->get($this->apiBaseUrl . '/payments', [
                'status' => 'pending'
            ]);

            if ($response->successful()) {
                $payments = $response->json('data') ?? [];
                
                return DataTables::of(collect($payments))
                    ->addIndexColumn()
                    ->addColumn('company', fn($p) => $p['company']['name'] ?? $p['company_name'] ?? 'N/A')
                    ->addColumn('plan', fn($p) => $p['plan']['name'] ?? $p['plan_name'] ?? 'N/A')
                    ->addColumn('amount', fn($p) => number_format($p['amount'] ?? 0, 2))
                    ->addColumn('method', fn($p) => '<span class="badge bg-info text-dark">' . strtoupper($p['method'] ?? 'N/A') . '</span>')
                    ->addColumn('transaction_id', fn($p) => $p['transaction_id'] ?? 'N/A')
                    ->addColumn('created_at', fn($p) => isset($p['created_at']) ? Carbon::parse($p['created_at'])->format('d M Y H:i') : 'N/A')
                    ->rawColumns(['method'])
                    ->make(true);
            }
            
            return DataTables::of(collect([]))->make(true);
        } catch (\Exception $e) {
            return DataTables::of(collect([]))->make(true);
        }
    }

    public function getUsers(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ])->get($this->apiBaseUrl . '/users');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json('data') ?? []
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch users from API'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPendingPayments(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ])->get($this->apiBaseUrl . '/payments', [
                'status' => 'pending'
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json('data') ?? []
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch payments from API'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}