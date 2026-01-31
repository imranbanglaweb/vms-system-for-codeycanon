<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\Menu;
use App\Models\Contact;
use App\Models\Document;
Use \Carbon\Carbon;
use DB;
use Auth;
use App\Models\User;
use App\Models\Department;
// use Illuminate\Support\Facades\DB;
use App\Services\TranslationService;

class HomeController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->middleware('auth');
        $this->translationService = $translationService;
        
        // Ensure dashboard translations exist
        $this->ensureDashboardTranslations();
    }
    
    private function ensureDashboardTranslations()
    {
        $languages = available_languages();
        $translations = [
            'total' => 'Total',
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'latest_requisitions' => 'Latest Requisitions',
            'employee' => 'Employee',
            'date' => 'Date',
            'status' => 'Status',
            'requisitions' => 'Requisitions',
            'departments' => 'Departments',
            'top_users' => 'Top Users',
            'monthly_requisitions' => 'Monthly Requisitions',
            'dashboard_overview' => 'Dashboard Overview',
            'status_progress' => 'Status Progress',
            'department_wise_requests' => 'Department-wise Requests',
            'status_ratio' => 'Status Ratio',
            'top_active_users' => 'Top Active Users',
            'recent_workflow_activity' => 'Recent Workflow Activity',
        ];
        
        foreach ($translations as $key => $default) {
            $existing = \DB::table('translations')
                ->where('group', 'backend')
                ->where('key', $key)
                ->first();
            if (!$existing) {
                foreach ($languages as $language) {
                    $this->translationService->set($key, $default, 'backend', $language->code);
                }
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        // Debug: Log user info
        \Log::info('Dashboard Access', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role_column' => $user->role,
            'user_roles' => $user->getRoleNames()->toArray(),
        ]);
        
        // Determine role-based query base using Spatie's hasRole method
        $isAdmin = $user->hasRole('Super Admin') || $user->hasRole('Admin');
        $isManager = $user->hasRole('Department Head') || $user->hasRole('Manager');
        $isTransport = $user->hasRole('Transport');
        $isEmployee = $user->hasRole('Employee');
        
        // Debug: Log role detection
        \Log::info('Role Detection', [
            'isAdmin' => $isAdmin,
            'isManager' => $isManager,
            'isTransport' => $isTransport,
            'isEmployee' => $isEmployee,
        ]);
        
        // Fallback to 'role' column if no Spatie role is assigned
        if (!$isAdmin && !$isManager && !$isTransport && !$isEmployee) {
            $userRole = $user->role ?? 'employee';
            $isAdmin = ($userRole === 'admin');
            $isManager = ($userRole === 'manager');
            $isTransport = ($userRole === 'transport');
            $isEmployee = ($userRole === 'employee');
            \Log::info('Fallback to role column', ['userRole' => $userRole]);
        }
        
        // Build base query based on role
        $baseQuery = Requisition::query();
        
        if ($isManager && $user->department_id) {
            // Managers see only their department's requisitions
            $baseQuery->where('department_id', $user->department_id);
        }
        
        // Role-based requisition visibility for lists
        if ($isEmployee) {
            $requisitions = Requisition::where('requested_by', $user->id)->latest()->get();
        } elseif ($isTransport) {
            // Transport sees pending transport approval (department_status = Approved, transport_status = Pending)
            $requisitions = Requisition::where('department_status', 'Approved')
                ->where('transport_status', 'Pending')
                ->latest()->get();
        } elseif ($isManager) {
            // Manager sees pending department approval
            $requisitions = Requisition::where('department_status', 'Pending')
                ->where('requested_by', $user->id)
                ->latest()->get();
        } else {
            // Admin/Super Admin sees all
            $requisitions = Requisition::latest()->get();
        }

        // Dashboard counters (role-based)
        if ($isAdmin) {
            $transportPending = Requisition::where('transport_status', 'Pending')->count();
            $transportApproved = Requisition::where('transport_status', 'Approved')->count();
            $transportRejected = Requisition::where('transport_status', 'Rejected')->count();
            $adminPending = 0;
            $adminApproved = 0;
            $adminRejected = 0;
        } elseif ($isTransport) {
            $transportPending = Requisition::where('department_status', 'Approved')
                ->where('transport_status', 'Pending')->count();
            $transportApproved = Requisition::where('transport_status', 'Approved')->count();
            $transportRejected = Requisition::where('transport_status', 'Rejected')->count();
            $adminPending = 0;
            $adminApproved = 0;
            $adminRejected = 0;
        } elseif ($isManager) {
            $transportPending = 0;
            $transportApproved = 0;
            $transportRejected = 0;
            $adminPending = 0;
            $adminApproved = 0;
            $adminRejected = 0;
        } else {
            $transportPending = 0;
            $transportApproved = 0;
            $transportRejected = 0;
            $adminPending = 0;
            $adminApproved = 0;
            $adminRejected = 0;
        }

        // Dashboard counters (overall with role-based filtering)
        $statusQuery = Requisition::query();
        if ($isManager && $user->department_id) {
            $statusQuery->where('department_id', $user->department_id);
        } elseif ($isEmployee) {
            $statusQuery->where('requested_by', $user->id);
        }
        // Note: Transport users see all requisitions for counting purposes
        // The filtering for transport users is done in the requisition list
        
        $chartData = [
            'Pending' => (clone $statusQuery)->where('department_status', 'Pending')->count(),
            'Dept_Approved' => (clone $statusQuery)->where('department_status', 'Approved')->count(),
            'Transport_Pending' => (clone $statusQuery)->where('department_status', 'Approved')->where('transport_status', 'Pending')->count(),
            'Transport_Approved' => (clone $statusQuery)->where('transport_status', 'Approved')->count(),
            'Rejected' => (clone $statusQuery)->where(function($q) {
                $q->where('department_status', 'Rejected')->orWhere('transport_status', 'Rejected');
            })->count(),
            'Completed' => (clone $statusQuery)->where('status', 'Completed')->count(),
        ];

        $pendingRequisitions = (clone $statusQuery)->where('department_status', 'Pending')->latest()->take(5)->get();
        $recentRequisitions = (clone $statusQuery)->latest()->take(10)->get();

        // Overall counts (role-based)
        $total = (clone $statusQuery)->count();
        $pending = (clone $statusQuery)->where('department_status', 'Pending')->count();
        $deptApproved = (clone $statusQuery)->where('department_status', 'Approved')->count();
        $transportPendingCount = (clone $statusQuery)->where('department_status', 'Approved')->where('transport_status', 'Pending')->count();
        $transportApproved = (clone $statusQuery)->where('transport_status', 'Approved')->count();
        $rejected = (clone $statusQuery)->where(function($q) {
            $q->where('department_status', 'Rejected')->orWhere('transport_status', 'Rejected');
        })->count();
        $completed = (clone $statusQuery)->where('status', 'Completed')->count();
        $cancelled = (clone $statusQuery)->where('status', 'Cancelled')->count();

        // Latest requisitions (role-based)
        $latestQuery = Requisition::with(['employee', 'vehicleType']);
        if ($isManager && $user->department_id) {
            $latestQuery->where('department_id', $user->department_id);
        } elseif ($isEmployee) {
            $latestQuery->where('requested_by', $user->id);
        }
        $latest = $latestQuery->orderBy('created_at', 'desc')->take(10)->get();

        // Monthly requisitions for last 12 months (chart 1) - role-based
        $months = collect();
        $monthLabels = [];
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $label = $dt->format('M Y');
            $monthLabels[] = $label;
            $months->push($dt->format('Y-m'));
        }

        $monthlyQuery = Requisition::select(
                DB::raw("DATE_FORMAT(travel_date, '%Y-%m') as ym"),
                DB::raw('count(*) as total')
            )
            ->whereBetween('travel_date', [Carbon::now()->subMonths(11)->startOfMonth(), Carbon::now()->endOfMonth()]);
        
        if ($isManager && $user->department_id) {
            $monthlyQuery->where('department_id', $user->department_id);
        } elseif ($isEmployee) {
            $monthlyQuery->where('requested_by', $user->id);
        }
        
        $monthlyCounts = $monthlyQuery
            ->groupBy('ym')
            ->pluck('total','ym')
            ->toArray();

        foreach ($months as $m) {
            $monthlyData[] = isset($monthlyCounts[$m]) ? (int)$monthlyCounts[$m] : 0;
        }

        // Department-wise requests (pie) (chart 2) - role-based
        $deptQuery = Requisition::select('departments.department_name as label', DB::raw('count(*) as value'))
            ->join('departments', 'requisitions.department_id', '=', 'departments.id');
        
        if ($isManager && $user->department_id) {
            $deptQuery->where('requisitions.department_id', $user->department_id);
            $deptData = collect([['label' => $user->department->department_name ?? 'Department', 'value' => $total]]);
        } elseif ($isEmployee) {
            $deptQuery->where('requisitions.requested_by', $user->id);
            $deptData = $deptQuery->groupBy('departments.department_name')->orderBy('value','desc')->limit(10)->get();
        } else {
            $deptData = $deptQuery->groupBy('departments.department_name')->orderBy('value','desc')->limit(10)->get();
        }

        // Status ratio (doughnut) (chart 3)
        $statusCounts = collect([
            'Pending' => $pending,
            'Dept Approved' => $deptApproved,
            'Transport Pending' => $transportPendingCount,
            'Transport Approved' => $transportApproved,
            'Rejected' => $rejected,
            'Completed' => $completed
        ]);

        // Top active users (chart 4) - role-based
        $topUsersQuery = Requisition::select('requested_by', DB::raw('count(*) as total'))
            ->groupBy('requested_by')
            ->orderBy('total','desc')
            ->with('requestedBy')
            ->limit(8);
        
        if ($isManager && $user->department_id) {
            $topUsersQuery->where('department_id', $user->department_id);
        } elseif ($isEmployee) {
            $topUsersQuery->where('requested_by', $user->id);
        }
        
        $topUsers = $topUsersQuery->get()
            ->map(function($r){
                return [
                    'name' => optional($r->requestedBy)->name ?? 'User '.$r->requested_by,
                    'total' => (int) $r->total
                ];
            });

        // Recent workflow logs (timeline) - role-based
        $timelineQuery = DB::table('requisition_loghistories')
            ->join('users', 'requisition_loghistories.created_by', '=', 'users.id')
            ->select('requisition_loghistories.*', 'users.name as user_name')
            ->orderBy('requisition_loghistories.created_at', 'desc')
            ->limit(10);
        
        if ($isManager && $user->department_id) {
            $timelineQuery->join('requisitions', 'requisition_loghistories.requisition_id', '=', 'requisitions.id')
                ->where('requisitions.department_id', $user->department_id);
        } elseif ($isEmployee) {
            $timelineQuery->where('requisition_loghistories.created_by', $user->id);
        }
        
        $timeline = $timelineQuery->get();

        // Build payload for view
        $cards = [
            ['key' => 'total', 'label' => $this->translationService->get('total', 'backend'), 'value' => $total, 'color' => '#0d6efd', 'icon' => 'fa-layer-group'],
            ['key' => 'pending', 'label' => $this->translationService->get('pending', 'backend'), 'value' => $pending, 'color' => '#ffc107', 'icon' => 'fa-hourglass-half'],
            ['key' => 'dept_approved', 'label' => 'Dept Approved', 'value' => $deptApproved, 'color' => '#17a2b8', 'icon' => 'fa-building'],
            ['key' => 'transport_pending', 'label' => 'Transport Pending', 'value' => $transportPendingCount, 'color' => '#fd7e14', 'icon' => 'fa-truck'],
            ['key' => 'transport_approved', 'label' => 'Transport Approved', 'value' => $transportApproved, 'color' => '#20c997', 'icon' => 'fa-check-circle'],
            ['key' => 'rejected', 'label' => $this->translationService->get('rejected', 'backend'), 'value' => $rejected, 'color' => '#dc3545', 'icon' => 'fa-times-circle'],
            ['key' => 'completed', 'label' => $this->translationService->get('completed', 'backend'), 'value' => $completed, 'color' => '#28a745', 'icon' => 'fa-flag-checkered'],
        ];

        // Sparkline data (dummy for last 7 days)
        $sparklineLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $sparklineData = [
            'total' => [rand(10,100), rand(10,100), rand(10,100), rand(10,100), rand(10,100), rand(10,100), rand(10,100)],
            'pending' => [rand(5,50), rand(5,50), rand(5,50), rand(5,50), rand(5,50), rand(5,50), rand(5,50)],
            'approved' => [rand(0,20), rand(0,20), rand(0,20), rand(0,20), rand(0,20), rand(0,20), rand(0,20)],
            'rejected' => [rand(0,10), rand(0,10), rand(0,10), rand(0,10), rand(0,10), rand(0,10), rand(0,10)],
            'completed' => [rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30)],
            'cancelled' => [rand(0,5), rand(0,5), rand(0,5), rand(0,5), rand(0,5), rand(0,5), rand(0,5)],
        ];

        $payload = [
            'total' => $total,
            'pending' => $pending,
            'deptApproved' => $deptApproved,
            'transportPending' => $transportPendingCount,
            'transportApproved' => $transportApproved,
            'rejected' => $rejected,
            'completed' => $completed,
            'cancelled' => $cancelled,
            'latest' => $latest,
            'monthLabels' => $monthLabels,
            'monthlyData' => $monthlyData,
            'deptData' => $deptData,
            'statusCounts' => $statusCounts,
            'topUsers' => $topUsers,
            'timeline' => $timeline,
            'cards' => $cards,
            'sparklineLabels' => $sparklineLabels,
            'sparklineData' => $sparklineData,
            'transportPendingCount' => $transportPending,
            'transportApprovedCount' => $transportApproved,
            'transportRejectedCount' => $transportRejected,
            'isAdmin' => $isAdmin,
            'isManager' => $isManager,
            'isTransport' => $isTransport,
            'isEmployee' => $isEmployee,
        ];

        return view('admin.dashboard.dashboard', $payload);
    } 

     /**
     * Endpoint for live AJAX refresh (cards + latest table + charts data)
     */
    public function data(Request $request)
    {
        $user = Auth::user();
        
        // Determine role-based query base using Spatie's hasRole method
        $isAdmin = $user->hasRole('Super Admin') || $user->hasRole('Admin');
        $isManager = $user->hasRole('Department Head') || $user->hasRole('Manager');
        $isTransport = $user->hasRole('Transport');
        $isEmployee = $user->hasRole('Employee');
        
        // Fallback to 'role' column if no Spatie role is assigned
        if (!$isAdmin && !$isManager && !$isTransport && !$isEmployee) {
            $userRole = $user->role ?? 'employee';
            $isAdmin = ($userRole === 'admin');
            $isManager = ($userRole === 'manager');
            $isTransport = ($userRole === 'transport');
            $isEmployee = ($userRole === 'employee');
        }
        
        // Build base query based on role
        $baseQuery = Requisition::query();
        
        if ($isManager && $user->department_id) {
            $baseQuery->where('department_id', $user->department_id);
        } elseif ($isEmployee) {
            $baseQuery->where('requested_by', $user->id);
        }
        // Note: Transport users see all requisitions for counting purposes
        
        $total = (clone $baseQuery)->count();
        $pending = (clone $baseQuery)->where('department_status', 'Pending')->count();
        $deptApproved = (clone $baseQuery)->where('department_status', 'Approved')->count();
        $transportPending = (clone $baseQuery)->where('department_status', 'Approved')->where('transport_status', 'Pending')->count();
        $transportApproved = (clone $baseQuery)->where('transport_status', 'Approved')->count();
        $rejected = (clone $baseQuery)->where(function($q) {
            $q->where('department_status', 'Rejected')->orWhere('transport_status', 'Rejected');
        })->count();
        $completed = (clone $baseQuery)->where('status', 'Completed')->count();

        $latestQuery = Requisition::with(['employee']);
        if ($isManager && $user->department_id) {
            $latestQuery->where('department_id', $user->department_id);
        } elseif ($isEmployee) {
            $latestQuery->where('requested_by', $user->id);
        } elseif ($isTransport) {
            $latestQuery->where('department_status', 'Approved')->where('transport_status', 'Pending');
        }
        $latest = $latestQuery->orderBy('created_at', 'desc')->take(10)->get();

        // Department breakdown (role-based)
        $deptQuery = Requisition::select('departments.department_name as label', DB::raw('count(*) as value'))
            ->join('departments', 'requisitions.department_id', '=', 'departments.id');
        
        if ($isManager && $user->department_id) {
            $deptData = collect([['label' => $user->department->department_name ?? 'Department', 'value' => $total]]);
        } elseif ($isEmployee) {
            $deptQuery->where('requisitions.requested_by', $user->id);
            $deptData = $deptQuery->groupBy('departments.department_name')->orderBy('value','desc')->limit(10)->get();
        } elseif ($isTransport) {
            // Transport users see all departments for counting purposes
            $deptData = $deptQuery->groupBy('departments.department_name')->orderBy('value','desc')->limit(10)->get();
        } else {
            $deptData = $deptQuery->groupBy('departments.department_name')->orderBy('value','desc')->limit(10)->get();
        }

        return response()->json([
            'total' => $total,
            'pending' => $pending,
            'deptApproved' => $deptApproved,
            'transportPending' => $transportPending,
            'transportApproved' => $transportApproved,
            'rejected' => $rejected,
            'completed' => $completed,
            'latest' => $latest,
            'deptData' => $deptData,
            'isAdmin' => $isAdmin,
            'isManager' => $isManager,
            'isTransport' => $isTransport,
            'isEmployee' => $isEmployee,
        ]);
    }


    

   
}
