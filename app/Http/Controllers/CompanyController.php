<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Company;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use \DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use App\Exports\ExportLandinventory;
Use \Carbon\Carbon;
Use Redirect;
Use Session;
use App\Services\TenantProvisioningService;
use App\Services\QuotaService;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;


class CompanyController extends Controller
{
    protected $tenantService;
    protected $quotaService;

    public function __construct(TenantProvisioningService $tenantService, QuotaService $quotaService)
    {
        $this->tenantService = $tenantService;
        $this->quotaService = $quotaService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.company.index');
    }

    /**
     * Get data for DataTables
     */
    public function data()
    {
        $companies = Company::with(['subscription.plan', 'users', 'vehicles'])->select(['id', 'company_name', 'company_code', 'status', 'created_at']);

        return DataTables::of($companies)
            ->addIndexColumn()
            ->addColumn('company_info', function($row) {
                $admin = $row->users()->whereHas('roles', function($q) {
                    $q->where('name', 'Admin');
                })->first();

                $html = '<div>';
                $html .= '<strong>' . $row->company_name . '</strong>';
                $html .= '<br><small class="text-muted">' . $row->company_code . '</small>';
                if ($admin) {
                    $html .= '<br><small class="text-muted"><i class="fa fa-user"></i> ' . $admin->name . ' (' . $admin->email . ')</small>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('subscription_info', function($row) {
                if ($row->subscription) {
                    $statusClass = $row->subscription->status === 'active' ? 'success' : 'warning';
                    $html = '<span class="badge bg-' . $statusClass . '">' . ucfirst($row->subscription->status) . '</span>';
                    $html .= '<br><small class="text-muted">' . ($row->subscription->plan->name ?? 'Unknown Plan') . '</small>';
                    return $html;
                }
                return '<span class="badge bg-secondary">No Subscription</span>';
            })
            ->addColumn('status_badge', function($row) {
                $statusClass = $row->status ? 'success' : 'danger';
                $statusText = $row->status ? 'Active' : 'Inactive';
                return '<span class="badge bg-' . $statusClass . '">' . $statusText . '</span>';
            })
            ->addColumn('users_count', function($row) {
                return $row->users()->count();
            })
            ->addColumn('vehicles_count', function($row) {
                return $row->vehicles()->count();
            })
            ->addColumn('created_date', function($row) {
                return $row->created_at->format('M d, Y');
            })
            ->addColumn('action', function($row) {
                $btn = '<div class="action-btns">';
                $btn .= '<a href="' . route('company.tenant-details', $row->id) . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Details</a> ';
                $btn .= '<button class="btn btn-primary btn-sm editCompany" data-id="'.$row->id.'" data-name="'.$row->company_name.'" data-code="'.$row->company_code.'"><i class="fa fa-edit"></i> Edit</button> ';

                if ($row->status) {
                    $btn .= '<button class="btn btn-warning btn-sm deactivateCompany" data-id="'.$row->id.'"><i class="fa fa-ban"></i> Deactivate</button> ';
                } else {
                    $btn .= '<button class="btn btn-success btn-sm reactivateCompany" data-id="'.$row->id.'"><i class="fa fa-check"></i> Reactivate</button> ';
                }

                $btn .= '<button class="btn btn-danger btn-sm deleteCompany" data-id="'.$row->id.'"><i class="fa fa-trash"></i> Delete</button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['company_info', 'subscription_info', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.dashboard.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $validator = Validator::make($request->all(), [
              'company_name' => 'required|string|max:255',
              'company_code' => 'required|string|max:50|unique:companies,company_code',
          ]);

          if ($validator->fails()) {
              return response()->json(['errors' => $validator->errors()->all()], 400);
          }

          $company = Company::updateOrCreate(
              ['id' => $request->id],
              [
                  'company_name' => $request->company_name,
                  'company_code' => $request->company_code,
                  'unit_id' => $request->unit_id,
                  'remarks' => $request->remarks,
                  'status' => $request->status ?? 'active',
                  'created_by' => Auth::id(),
              ]
          );

          return response()->json(['message' => 'Company saved successfully']);
    }

     /**
      * Display the specified resource.
      *
      * @param  \App\Models\Company  $company
      * @return \Illuminate\Http\Response
      */
     public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $units = Unit::all();
        return view('admin.dashboard.company.edit', compact('company', 'units'));
    }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \App\Models\Company  $company
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::find($id)->delete();
        return response()->json(['message' => 'Company deleted successfully']);
    }

    // ============ SaaS Functionality Methods ============

    /**
     * Show detailed company/tenant information with SaaS features
     */
    public function tenantDetails(Company $company)
    {
        $company->load(['subscription.plan', 'users.roles', 'departments', 'units', 'vehicles']);

        $usageStats = $this->quotaService->getUsageStats($company);
        $quotaAlerts = $this->quotaService->getQuotaAlerts($company);

        return view('admin.dashboard.company.tenant-details', compact('company', 'usageStats', 'quotaAlerts'));
    }

    /**
     * Upgrade/downgrade company subscription
     */
    public function upgradeSubscription(Request $request, Company $company)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id'
        ]);

        $newPlan = SubscriptionPlan::findOrFail($request->plan_id);

        try {
            $this->tenantService->upgradeSubscription($company, $newPlan);

            return response()->json([
                'success' => true,
                'message' => 'Subscription upgraded successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upgrade subscription: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deactivate company (tenant)
     */
    public function deactivate(Company $company)
    {
        try {
            $this->tenantService->deactivateTenant($company);

            return response()->json([
                'success' => true,
                'message' => 'Company deactivated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate company: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reactivate company (tenant)
     */
    public function reactivate(Company $company)
    {
        try {
            $this->tenantService->reactivateTenant($company);

            return response()->json([
                'success' => true,
                'message' => 'Company reactivated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reactivate company: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export company data (GDPR compliance)
     */
    public function exportData(Company $company)
    {
        $data = [
            'company' => $company->toArray(),
            'users' => $company->users()->with('roles')->get(),
            'vehicles' => $company->vehicles,
            'departments' => $company->departments,
            'subscription' => $company->subscription,
            'exported_at' => now(),
        ];

        return response()->json($data);
    }

    /**
     * Get company usage statistics
     */
    public function statistics(Company $company)
    {
        return response()->json([
            'users_count' => $company->users()->count(),
            'vehicles_count' => $company->vehicles()->count(),
            'departments_count' => $company->departments()->count(),
            'active_requisitions' => $company->requisitions()->where('status', 'active')->count() ?? 0,
            'subscription_status' => $company->subscription?->status ?? 'none',
            'subscription_plan' => $company->subscription?->plan?->name ?? 'none',
            'usage_stats' => $this->quotaService->getUsageStats($company),
            'quota_alerts' => $this->quotaService->getQuotaAlerts($company),
        ]);
    }

    /**
     * Provision new company with SaaS setup
     */
    public function provisionCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'company_code' => 'nullable|string|max:50|unique:companies,company_code',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'email' => 'nullable|email',
            'plan_id' => 'nullable|exists:subscription_plans,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Provision the tenant (company)
            $company = $this->tenantService->provisionTenant($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Company provisioned successfully',
                'company_id' => $company->id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to provision company: ' . $e->getMessage()
            ], 500);
        }
    }


}
