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

        $transportPending = Requisition::where('status', 2)->count();
        $transportApproved = Requisition::where('status', 4)->count();
        $transportRejected = Requisition::where('status', 5)->count();

        $adminPending = Requisition::where('status', 4)->count();
        $adminApproved = Requisition::where('status', 6)->count();
        $adminRejected = Requisition::where('status', 7)->count();


        // Dashboard counters
      $chartData = [
            'Pending' => Requisition::where('status', 'Pending')->count(),
            'Approved' => Requisition::where('status', 'Approved')->count(),
            'Dept_Approved' => Requisition::where('status','Dept_Approved')->count(),
            'Transport_Approved' => Requisition::where('status','Transport_Approved')->count(),
            'GM_Approved' => Requisition::where('status','GM_Approved')->count(),
            'Rejected' => Requisition::where('status','Rejected')->count(),
            'Completed' => Requisition::where('status','Completed')->count(),
        ];

        $pendingRequisitions = Requisition::where('status', 'Pending')->latest()->take(5)->get();
        $recentRequisitions = Requisition::latest()->take(10)->get();

        // Role-based requisition visibility
        if ($user->role === 'employee') {
            $requisitions = Requisition::where('requested_by', $user->id)->latest()->get();
        }
        elseif ($user->role === 'transport') {
            $requisitions = Requisition::where('status', 1)->latest()->get(); // waiting transport
        }
        else { // admin
            $requisitions = Requisition::where('status', 2)->latest()->get(); // waiting admin approval
        }

          // Overall counts
        $total = Requisition::count();
        $pending = Requisition::where('status', 1)->count();
        $approved = Requisition::where('status', 3)->count();
        $rejected = Requisition::where('status', 4)->count();
        $completed = Requisition::where('status', 5)->count();
        $cancelled = Requisition::where('status', 'Cancelled')->count(); // if used

        // Latest 10 requisitions
        $latest = Requisition::with(['requestedBy', 'vehicle', 'driver'])
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();

        // Monthly requisitions for last 12 months (chart 1)
        $months = collect();
        $monthLabels = [];
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $label = $dt->format('M Y');
            $monthLabels[] = $label;
            $months->push($dt->format('Y-m'));
        }

        $monthlyCounts = Requisition::select(
                DB::raw("DATE_FORMAT(travel_date, '%Y-%m') as ym"),
                DB::raw('count(*) as total')
            )
            ->whereBetween('travel_date', [Carbon::now()->subMonths(11)->startOfMonth(), Carbon::now()->endOfMonth()])
            ->groupBy('ym')
            ->pluck('total','ym')
            ->toArray();

        foreach ($months as $m) {
            $monthlyData[] = isset($monthlyCounts[$m]) ? (int)$monthlyCounts[$m] : 0;
        }

        // Department-wise requests (pie) (chart 2)
        $deptData = Requisition::select('departments.department_name as label', DB::raw('count(*) as value'))
            ->join('departments', 'requisitions.department_id', '=', 'departments.id')
            ->groupBy('departments.department_name')
            ->orderBy('value','desc')
            ->limit(10)
            ->get();

        // Status ratio (doughnut) (chart 3)
        $statusCounts = collect([
            'Pending' => $pending,
            'Approved' => $approved,
            'Rejected' => $rejected,
            'Completed' => $completed
        ]);

        // Top active users (chart 4)
        $topUsers = Requisition::select('requested_by', DB::raw('count(*) as total'))
            ->groupBy('requested_by')
            ->orderBy('total','desc')
            ->with('requestedBy')
            ->limit(8)
            ->get()
            ->map(function($r){
                return [
                    'name' => optional($r->requestedBy)->name ?? 'User '.$r->requested_by,
                    'total' => (int) $r->total
                ];
            });

        // Recent workflow logs (timeline)
        $timeline = DB::table('requisition_loghistories')
            ->join('users', 'requisition_loghistories.created_by', '=', 'users.id')
            ->select('requisition_loghistories.*', 'users.name as user_name')
            ->orderBy('requisition_loghistories.created_at', 'desc')
            ->limit(10)
            ->get();

        // Build payload for view
        $cards = [
            ['key' => 'total', 'label' => $this->translationService->get('total', 'backend'), 'value' => $total, 'color' => '#0d6efd', 'icon' => 'fa-layer-group'],
            ['key' => 'pending', 'label' => $this->translationService->get('pending', 'backend'), 'value' => $pending, 'color' => '#ffc107', 'icon' => 'fa-hourglass-half'],
            ['key' => 'approved', 'label' => $this->translationService->get('approved', 'backend'), 'value' => $approved, 'color' => '#20c997', 'icon' => 'fa-check-circle'],
            ['key' => 'rejected', 'label' => $this->translationService->get('rejected', 'backend'), 'value' => $rejected, 'color' => '#dc3545', 'icon' => 'fa-times-circle'],
            ['key' => 'completed', 'label' => $this->translationService->get('completed', 'backend'), 'value' => $completed, 'color' => '#28a745', 'icon' => 'fa-flag-checkered'],
            ['key' => 'cancelled', 'label' => $this->translationService->get('cancelled', 'backend'), 'value' => $cancelled, 'color' => '#6c757d', 'icon' => 'fa-ban'],
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
            'approved' => $approved,
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
        ];

        // return view('admin.dashboard.dashboard', compact('stats', 'requisitions', 'user'));
        //  return view('admin.dashboard.dashboard', 
        //  compact(
        // 'chartData', 
        //  'pendingRequisitions', 
        //  'recentRequisitions',
        //  'transportPending',
        //  'transportApproved',
        //  'transportRejected',
        //   'adminPending', 'adminApproved', 'adminRejected'
        //  )
        // );

         return view('admin.dashboard.dashboard', $payload);
    } 

     /**
     * Endpoint for live AJAX refresh (cards + latest table + charts data)
     */
    public function data(Request $request)
    {
        $total = Requisition::count();
        $pending = Requisition::where('status', 1)->count();
        $approved = Requisition::where('status', 3)->count();
        $rejected = Requisition::where('status', 4)->count();
        $completed = Requisition::where('status', 5)->count();

        $latest = Requisition::with(['requestedBy'])
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();

        // small dept breakdown
        $deptData = Requisition::select('departments.department_name as label', DB::raw('count(*) as value'))
            ->join('departments', 'requisitions.department_id', '=', 'departments.id')
            ->groupBy('departments.department_name')
            ->orderBy('value','desc')
            ->limit(10)
            ->get();

        return response()->json([
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'completed' => $completed,
            'latest' => $latest,
            'deptData' => $deptData,
        ]);
    }


    

   
}
