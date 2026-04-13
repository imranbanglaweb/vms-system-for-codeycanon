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
    protected $apiToken = '2|nRwYaSJDJQom1TOLQksZQSS8S2bRu76Hde4YbRhF248df895';

    public function index(Request $request)
    {
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
                
                $indexedUsers = array_values(array_map(function($u, $index) {
                    return [
                        'DT_RowIndex' => $index + 1,
                        'name' => $u['name'] ?? 'N/A',
                        'email' => $u['email'] ?? 'N/A',
                        'cell_phone' => $u['cell_phone'] ?? $u['phone'] ?? 'N/A',
                        'company' => 'N/A',
                        'created_at' => isset($u['created_at']) ? Carbon::parse($u['created_at'])->format('d M Y') : 'N/A',
                        'status' => '<span class="badge bg-success">Active</span>'
                    ];
                }, $users, array_keys($users)));
                
                return response()->json(['data' => $indexedUsers]);
            }
            
            return response()->json(['data' => [], 'error' => 'API error: ' . $response->status()]);
        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()]);
        }
    }

    protected function getPendingPaymentsDataTable(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ])->get($this->apiBaseUrl . '/all-payments');

            if ($response->status() === 404) {
                return response()->json(['data' => []]);
            }
            
            if ($response->successful()) {
                $responseData = $response->json('data');
                $payments = $responseData['data'] ?? $responseData ?? [];
                
                $indexedPayments = array_values(array_map(function($p, $index) {
                    return [
                        'DT_RowIndex' => $index + 1,
                        'customer_name' => $p['customer_name'] ?? 'N/A',
                        'plan_name' => $p['subscription']['package']['name'] ?? $p['subscription']['package']['name_bn'] ?? 'N/A',
                        'amount' => number_format(floatval($p['amount'] ?? 0), 2),
                        'payment_method' => '<span class="badge bg-info text-dark">' . strtoupper($p['payment_method'] ?? 'N/A') . '</span>',
                        'transaction_id' => $p['transaction_id'] ?? 'N/A',
                        'created_at' => isset($p['created_at']) ? Carbon::parse($p['created_at'])->format('d M Y H:i') : 'N/A'
                    ];
                }, $payments, array_keys($payments)));
                
                return response()->json(['data' => $indexedPayments]);
            }
            
            return response()->json(['data' => []]);
        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()]);
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
                'message' => 'Failed to fetch users from API. Status: ' . $response->status() . ' - ' . $response->body()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
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