<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Exports\RequisitionExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{
    public function requisitions(Request $request)
    {
        $query = Requisition::with(['employee', 'department']);

        if ($request->from_date) {
            $query->whereDate('requisition_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('requisition_date', '<=', $request->to_date);
        }

        if ($request->status !== null) {
            $query->where('status', $request->status);
        }

        $requisitions = $query->latest()->paginate(20);

        return view('admin.dashboard.reports.requisitions', compact('requisitions'));
    }

    public function requisitionsPdf(Request $request)
    {
        $data = Requisition::with(['employee','department'])->get();
        $pdf = PDF::loadView('admin.dashboard.reports.pdf.requisitions', compact('data'));
        return $pdf->download('requisition-report.pdf');
    }

    public function requisitionsExcel(Request $request)
    {
        return Excel::download(new RequisitionExport($request), 'requisition-report.xlsx');
    }
}
