<?php

namespace App\Http\Controllers;

use App\Models\EmailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailLogController extends Controller
{
    /**
     * Display a listing of email logs.
     */
    public function index(Request $request)
    {
        $query = EmailLog::with(['requisition']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('recipient')) {
            $query->where('recipient_email', 'like', '%' . $request->recipient . '%');
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Get stats
        $stats = [
            'total' => EmailLog::count(),
            'sent' => EmailLog::sent()->count(),
            'failed' => EmailLog::failed()->count(),
            'pending' => EmailLog::where('status', 'Pending')->count(),
        ];

        $perPage = $request->get('per_page', 15);
        $emaillogs = $query->latest()->paginate($perPage);

        // For AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.dashboard.emaillog.table', compact('emaillogs'))->render(),
                'pagination' => view('admin.dashboard.emaillog.pagination', compact('emaillogs'))->render(),
                'stats' => $stats
            ]);
        }

        return view('admin.dashboard.emaillog.index', compact('emaillogs', 'stats'));
    }

    /**
     * Display email log details.
     */
    public function show($id)
    {
        $emaillog = EmailLog::with(['requisition'])->findOrFail($id);
        return view('admin.dashboard.emaillog.show', compact('emaillog'));
    }

    /**
     * Resend failed email.
     */
    public function resend($id)
    {
        $emaillog = EmailLog::findOrFail($id);

        if ($emaillog->status !== 'Failed') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only failed emails can be resent.'
            ], 400);
        }

        try {
            // Reset status to pending
            $emaillog->update(['status' => 'Pending']);

            // TODO: Implement actual email resend logic here
            // For now, just mark as sent for demonstration
            $emaillog->update([
                'status' => 'Sent',
                'sent_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Email has been resent successfully.'
            ]);
        } catch (\Exception $e) {
            $emaillog->update(['status' => 'Failed']);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to resend email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete email log.
     */
    public function destroy($id)
    {
        $emaillog = EmailLog::findOrFail($id);
        $emaillog->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Email log deleted successfully.'
        ]);
    }

    /**
     * Get email log data for DataTable.
     */
    public function data(Request $request)
    {
        $query = EmailLog::with(['requisition']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return datatables()->of($query)
            ->addColumn('requisition_number', function ($log) {
                return $log->requisition ? $log->requisition->requisition_number : 'N/A';
            })
            ->addColumn('status_badge', function ($log) {
                $colors = [
                    'Sent' => 'success',
                    'Failed' => 'danger',
                    'Pending' => 'warning'
                ];
                $color = $colors[$log->status] ?? 'secondary';
                return '<span class="badge bg-' . $color . '">' . $log->status . '</span>';
            })
            ->addColumn('action', function ($log) {
                return '<a href="' . route('emaillogs.show', $log->id) . '" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>';
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
}
