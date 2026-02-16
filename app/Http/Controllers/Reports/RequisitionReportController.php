<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Employee;
use App\Models\VehicleType;
use App\Exports\RequisitionReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RequisitionReportController extends Controller
{
    public function index(Request $request)
        {
            // Check if user can only view own requisitions
            $user = auth()->user();
            $canViewOwnOnly = $user->hasPermissionTo('report-requisition-own') && !$user->hasPermissionTo('report-requisition');
            
            $query = Requisition::with([
                'requestedBy',
                'department',
                'unit',
                'vehicleType'
            ]);

            // If user can only view own requisitions, filter by current user
            if ($canViewOwnOnly) {
                $query->where('requested_by', $user->id);
            }

            /* ==========================
            GLOBAL SEARCH
            ========================== */
            if ($request->filled('keyword')) {
                $keyword = $request->keyword;

                $query->where(function ($q) use ($keyword) {
                    $q->where('requisition_number', 'like', "%{$keyword}%")
                    ->orWhere('from_location', 'like', "%{$keyword}%")
                    ->orWhere('to_location', 'like', "%{$keyword}%")
                    ->orWhereHas('requestedBy', fn($e) =>
                            $e->where('name', 'like', "%{$keyword}%"))
                    ->orWhereHas('department', fn($d) =>
                            $d->where('department_name', 'like', "%{$keyword}%"))
                    ->orWhereHas('unit', fn($u) =>
                            $u->where('unit_name', 'like', "%{$keyword}%"));
                });
            }

            /* ==========================
            ADVANCED FILTERS
            ========================== */
            if ($request->filled('department_id')) {
                $query->where('department_id', $request->department_id);
            }

            if ($request->filled('unit_id')) {
                $query->where('unit_id', $request->unit_id);
            }

            if ($request->filled('employee_id')) {
                $query->where('requested_by', $request->employee_id);
            }

            if ($request->filled('vehicle_type')) {
                $query->where('vehicle_type', $request->vehicle_type);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('from_date')) {
                $query->whereDate('travel_date', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->whereDate('travel_date', '<=', $request->to_date);
            }

            /* ==========================
            PAGINATION
            ========================== */
            $perPage = $request->get('per_page', 15);
            $requisitions = $query->latest()->paginate($perPage);

            if ($request->ajax()) {
                return view(
                    'admin.dashboard.reports.requisitions.table',
                    compact('requisitions')
                )->render();
            }

            return view(
                'admin.dashboard.reports.requisitions.index',
                [
                    'requisitions' => $requisitions,
                    'departments'  => Department::all(),
                    'units'        => Unit::all(),
                    'employees'    => Employee::all(),
                    'vehicleTypes' => VehicleType::all(),
                    'canViewOwnOnly' => $canViewOwnOnly,
                ]
            );
        }


    public function exportExcel(Request $request)
    {
        return Excel::download(
            new RequisitionReportExport($request),
            'requisition-report-'.date('Y-m-d').'.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = Requisition::with(['requestedBy', 'department', 'vehicleType']);

        // Apply filters from request
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('travel_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('travel_date', '<=', $request->to_date);
        }

        $data = $query->latest()->get();
        $pdf  = Pdf::loadView('admin.dashboard.reports.requisitions.pdf', compact('data'));

        return $pdf->download('requisition-report.pdf');
    }
}
