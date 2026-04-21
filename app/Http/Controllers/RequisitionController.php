<?php

namespace App\Http\Controllers;

use App\Jobs\SendRequisitionCreatedEmailJob;
use App\Mail\RequisitionStatusMail;
use App\Models\Department;
use App\Models\Driver;
use App\Models\Employee;
use App\Models\Requisition;
use App\Models\RequisitionLogHistory;
use App\Models\Unit;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Notifications\RequisitionCreated;
use App\Services\EmailService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RequisitionController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->middleware('auth');
        $this->emailService = $emailService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // Determine role-based query base
        $isAdmin = $user->hasRole('Super Admin') || $user->hasRole('Admin');
        $isManager = $user->hasRole('Department Head') || $user->hasRole('Manager');
        $isTransport = $user->hasRole('Transport');
        $isEmployee = $user->hasRole('Employee');

        // Fallback to role column if no Spatie role
        if (! $isAdmin && ! $isManager && ! $isTransport && ! $isEmployee) {
            $userRole = $user->role ?? 'employee';
            $isAdmin = ($userRole === 'admin');
            $isManager = ($userRole === 'manager');
            $isTransport = ($userRole === 'transport');
            $isEmployee = ($userRole === 'employee');
        }

        $query = Requisition::with(['employee', 'department', 'vehicle', 'driver']);

        // User-wise filtering
        if ($isEmployee) {
            // Employees see only their own requisitions
            $query->where('created_by', $user->id);
        } elseif ($isManager && $user->department_id) {
            // Managers see requisitions from their department
            $query->where('department_id', $user->department_id);
        } elseif ($isTransport) {
            // Transport users see requisitions that need transport approval
            $query->where('department_status', 'Approved')
                ->where('transport_status', 'Pending');
        }

        // Apply filters
        if ($request->filled('requisition_number')) {
            $query->where('requisition_number', 'like', '%'.$request->requisition_number.'%');
        }

        if ($request->filled('employee_name')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->employee_name.'%');
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('travel_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('travel_date', '<=', $request->end_date);
        }

        $perPage = $request->get('per_page', 10);
        $requisitions = $query->latest()->paginate($perPage);

        // For AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.dashboard.requisition.table', compact('requisitions'))->render(),
                'pagination' => view('admin.dashboard.requisition.pagination', compact('requisitions'))->render(),
                'stats' => [
                    'total' => $query->count(),
                    'pending' => (clone $query)->where('status', 0)->count(),
                    'approved' => (clone $query)->where('status', 1)->count(),
                    'rejected' => (clone $query)->where('status', 2)->count(),
                ],
            ]);
        }

        $departments = Department::all();
        $stats = [
            'total' => $query->count(),
            'pending' => (clone $query)->where('department_status', 'pending')->count(),
            'approved' => (clone $query)->where('department_status', 'approved')->count(),
            'rejected' => (clone $query)->where('department_status', 'rejected')->count(),
        ];

        return view('admin.dashboard.requisition.index', compact('requisitions', 'departments', 'stats'));
    }

    // EXPORT EXCEL
    public function exportExcel()
    {
        return Excel::download(new \App\Exports\RequisitionExport, 'requisitions.xlsx');
    }

    // EXPORT PDF
    public function exportPDF()
    {
        $requisitions = Requisition::with(['requestedBy', 'vehicle', 'driver'])->get();

        $pdf = PDF::loadView('admin.dashboard.requisition.pdf', compact('requisitions'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('requisitions.pdf');
    }

    public function create()
    {
        $user = Auth::user();
        $isEmployee = $user->hasRole('Employee');

        // Optimized queries: only fetch necessary columns
        $vehicles = Vehicle::where('status', 1)->select('id', 'vehicle_number', 'vehicle_name')->get();
        $drivers = Driver::where('status', 1)->select('id', 'driver_name')->get();
        $departments = Department::select('id', 'department_name')->get();
        $units = Unit::select('id', 'unit_name')->get();
        $vehicleTypes = VehicleType::select('id', 'name')->get();

        // Fetch all employees for passenger selection
        // Need to bypass company scope and filter by active status
        $employees = Employee::withoutGlobalScope(\App\Models\Scopes\CompanyScope::class)
            ->where('status', 'Active')
            ->select('id', 'name')
            ->get();

        // Determine selected employee (for employee role, pre-select themselves)
        $selectedEmployeeId = null;
        if ($isEmployee && $user->employee_id) {
            $selectedEmployeeId = $user->employee_id;
        }

        return view('admin.dashboard.requisition.create', [
            'action' => route('requisitions.store'),
            'method' => 'POST',
            'units' => $units,
            'requisition' => new Requisition,
            'vehicles' => $vehicles,
            'employees' => $employees,
            'departments' => $departments,
            'vehicleTypes' => $vehicleTypes,
            'drivers' => $drivers,
            'selectedEmployeeId' => $selectedEmployeeId,
        ]);
    }

    public function validateAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'requested_by' => 'required|exists:employees,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'travel_date' => 'required|date',
            'purpose' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Validation passed',
        ]);
    }

    public function store(Request $request)
    {

        // Complete validation for ALL form fields
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'requisition_date' => 'required|date', // Add this if it's in your form
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'travel_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:travel_date',
            'number_of_passenger' => 'nullable|integer|min:1',
            'purpose' => 'required|string|max:500', // Changed from nullable to required
            'passengers.*.employee_id' => 'required|exists:employees,id',
        ], [
            'employee_id.required' => 'Please select an employee',
            'vehicle_type.required' => 'Please select a vehicle Type',
            'driver_id.required' => 'Please select a driver',
            'requisition_date.required' => 'Requisition date is required',
            'from_location.required' => 'From location is required',
            'to_location.required' => 'To location is required',
            'travel_date.required' => 'Travel date is required',
            'purpose.required' => 'Purpose is required',
            'number_of_passenger.required' => 'Number of passengers is required',
            'passengers.*.employee_id.exists' => 'Selected passenger is invalid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Get employee record to auto-populate department and unit if not provided
        $employee = Employee::find($request->employee_id);
        DB::beginTransaction();
        try {
            $maxNumber = DB::table('requisitions')
                ->where('requisition_number', 'like', 'REQ-%')
                ->selectRaw('COALESCE(MAX(CAST(SUBSTRING(requisition_number, 5) AS UNSIGNED)), 0) + 1 as next_num')
                ->value('next_num');

            $requisition_number = 'REQ-'.str_pad($maxNumber, 5, '0', STR_PAD_LEFT);

            $maxRetries = 5;
            $created = false;

            while (! $created && $maxRetries > 0) {
                try {
                    $requisition = Requisition::create([
                        'requested_by' => $request->employee_id,
                        'company_id' => auth()->user()->company_id,
                        'vehicle_id' => $request->vehicle_id ?? null,
                        'department_id' => $request->department_id,
                        'unit_id' => $request->unit_id,
                        'vehicle_type' => $request->vehicle_type ?? null,
                        'driver_id' => $request->driver_id ?? null,
                        'requisition_number' => $requisition_number,
                        'from_location' => $request->from_location,
                        'to_location' => $request->to_location,
                        'requisition_date' => $request->requisition_date,
                        'number_of_passenger' => $request->number_of_passenger,
                        'travel_date' => $request->travel_date,
                        'return_date' => $request->return_date,
                        'purpose' => $request->purpose,
                        'status' => 'Pending',
                        'department_status' => 'Pending',
                        'transport_remarks' => 'Pending Department Approval',
                        'created_by' => auth()->id() ?? 1,
                    ]);
                    $created = true;

                    if (! empty($request->passengers)) {
                        try {
                            $passengerData = [];
                            foreach ($request->passengers as $passenger) {
                                if (! empty($passenger['employee_id'])) {
                                    $passengerData[] = [
                                        'requisition_id' => $requisition->id,
                                        'employee_id' => $passenger['employee_id'],
                                        'created_by' => auth()->id() ?? 1,
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ];
                                }
                            }
                            if (! empty($passengerData)) {
                                \App\Models\RequisitionPassenger::insert($passengerData);
                            }
                        } catch (\Exception $passengerError) {
                            \Log::warning('Failed to add passengers: '.$passengerError->getMessage());
                        }
                    }

                    DB::commit();

                    try {
                        if ($request->send_email_to_head == 1 && ! empty($request->department_head_email)) {
                            SendRequisitionCreatedEmailJob::dispatch($requisition, $request->department_head_email);
                        }
                        $this->sendRequisitionCreatedNotifications($requisition);
                    } catch (\Throwable $notifyError) {
                        \Log::warning('Post-create notification failed: '.$notifyError->getMessage());
                    }

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Requisition created successfully! (notifications may be delayed)',
                        'data' => $requisition,
                    ], 201);
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'Duplicate entry')) {
                        $maxRetries--;
                        if ($maxRetries > 0) {
                            $maxNumber = DB::table('requisitions')
                                ->where('requisition_number', 'like', 'REQ-%')
                                ->selectRaw('COALESCE(MAX(CAST(SUBSTRING(requisition_number, 5) AS UNSIGNED)), 0) + 1 as next_num')
                                ->value('next_num');
                            $requisition_number = 'REQ-'.str_pad($maxNumber, 5, '0', STR_PAD_LEFT);
                            \Log::warning("Requisition number collision, retrying with: $requisition_number");
                        }
                    } else {
                        throw $e;
                    }
                }
            }

            if (! $created) {
                throw new \Exception('Failed to create requisition after retries');
            }
        } catch (\Throwable $e) {
            try {
                DB::rollBack();
            } catch (\Exception $rollbackError) {
                \Log::warning('Rollback failed: '.$rollbackError->getMessage());
            }
            \Log::error('Requisition store error: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Server error while saving requisition: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $requisition = Requisition::with(['requestedBy', 'vehicle', 'driver', 'unit', 'passengers.employee'])
            ->findOrFail($id);

        return view('admin.dashboard.requisition.show', compact('requisition'));

    }

    /**
     * Edit form.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $isEmployee = $user->hasRole('Employee');

        $requisition = Requisition::with(['employee', 'department', 'vehicle', 'driver', 'passengers.employee'])->findOrFail($id);

        // Employee can only edit their own requisitions (check created_by which stores user_id)
        if ($isEmployee && $requisition->created_by != $user->id) {
            abort(403, 'You can only edit your own requisitions.');
        }

        $employees = Employee::all();
        $vehicleTypes = VehicleType::where('status', 1)->get();
        $drivers = Driver::all();
        $units = Unit::all();
        $departments = Department::all();
        $vehicles = Vehicle::where('status', 1)->get();

        return view('admin.dashboard.requisition.edit', compact(
            'requisition', 'employees', 'vehicleTypes', 'drivers', 'units', 'departments', 'vehicles'
        ));

    }

    /**
     * Update requisition.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $isEmployee = $user->hasRole('Employee');

            $requisition = Requisition::findOrFail($id);

            // Employee can only update their own requisitions (check created_by which stores user_id)
            if ($isEmployee && $requisition->created_by != $user->id) {
                abort(403, 'You can only update your own requisitions.');
            }

            // Validation
            $validator = Validator::make($request->all(), [
                // 'employee_id'           => 'required|exists:employees,id',
                'vehicle_id' => 'nullable|exists:vehicles,id',
                // 'driver_id'             => 'required|exists:drivers,id',
                'requisition_date' => 'required|date',
                'from_location' => 'required|string',
                'to_location' => 'required|string',
                'travel_date' => 'required|date',
                'number_of_passenger' => 'required|integer|min:1',
                'purpose' => 'required|string',
                // 'status'                => 'required|string',

                'passengers' => 'sometimes|array',
                'passengers.*.employee_id' => 'required|exists:employees,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // -------------------------------
            // 🔵 Update each field manually
            // -------------------------------
            $requisition->requested_by = $request->employee_id;
            $requisition->department_id = $request->department_id;
            $requisition->unit_id = $request->unit_id;
            $requisition->vehicle_id = $request->vehicle_id ?? null;
            $requisition->driver_id = $request->driver_id;
            $requisition->requisition_date = $request->requisition_date;
            $requisition->from_location = $request->from_location;
            $requisition->to_location = $request->to_location;
            $requisition->travel_date = $request->travel_date;
            $requisition->number_of_passenger = $request->number_of_passenger;
            $requisition->purpose = $request->purpose;
            $requisition->status = 'Pending';
            $requisition->created_by = auth()->id() ?? 1;
            // Do not update the requisition number
            $requisition->save();

            // -------------------------------
            // 🔵 Update Passengers
            // -------------------------------
            if ($request->has('passengers')) {

                // Remove old
                $requisition->passengers()->delete();

                // Insert new passengers
                foreach ($request->passengers as $passengerData) {
                    $requisition->passengers()->create([
                        'employee_id' => $passengerData['employee_id'],
                        'created_by' => auth()->id() ?? 1, // fallback for testing
                    ]);
                }
            }

            // Send email notification to department head (only if toggle is checked)
            if ($request->send_email_to_head == 1 && ! empty($request->department_head_email)) {
                try {
                    $this->emailService->sendRequisitionCreated($requisition, $request->department_head_email);
                    Log::info('Email notification sent for requisition updated: '.$requisition->requisition_number.' to: '.$request->department_head_email);
                } catch (\Exception $e) {
                    Log::error('Failed to send requisition updated email: '.$e->getMessage());
                }
            } else {
                Log::info('Email notification skipped for requisition update: '.$requisition->requisition_number.' (toggle not checked or no email provided)');
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Requisition updated successfully!',
                'redirect_url' => route('requisitions.index'),
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Error updating requisition: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete requisition.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $isEmployee = $user->hasRole('Employee');

        $requisition = Requisition::find($id);

        if (! $requisition) {
            return response()->json(['status' => 'error', 'message' => 'Requisition not found']);
        }

        // Employee can only delete their own requisitions
        if ($isEmployee && $requisition->requested_by != $user->id) {
            abort(403, 'You can only delete your own requisitions.');
        }

        $requisition->delete();

        return response()->json(['status' => 'success', 'message' => 'Requisition deleted successfully']);
    }

    public function getEmployeeDetails($id)
    {
        $emp = Employee::find($id);

        if (! $emp) {
            return response()->json(['status' => 'error', 'message' => 'Employee not found']);
        }

        return response()->json([
            'status' => 'success',
            'employee' => [
                'department' => $emp->department_name,
                'unit' => $emp->unit_name,
                'designation' => $emp->designation,
            ],
        ]);
    }

    public function updateWorkflow(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2,3,4,5',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $requisition = Requisition::findOrFail($id);

        // Role-based allowed transitions (example)
        $user = Auth::user();
        $newStatus = (int) $request->status;
        $oldStatus = (int) $requisition->status;

        // Example policy:
        // - employee cannot change status (except create)
        // - transport can move Requested(1) -> TransportReview(2) OR TransportReview(2) -> Pending/Approved? customize
        // - admin can Approve(3) or Reject(4) or Complete(5)
        if ($user->role === 'employee') {
            abort(403, 'Access Denied');
        }

        if ($user->role === 'transport') {
            // allow only transitions to 2 (review) or to 5 (completed) depending on your rules
            $allowed = [2];
            if (! in_array($newStatus, $allowed)) {
                abort(403, 'Transport role not allowed to set this status.');
            }
        }

        if ($user->role === 'admin') {
            // admin allowed any
        }

        // Update
        $requisition->update([
            'status' => $newStatus,
            'updated_by' => $user->id,
        ]);

        // Log
        RequisitionLoghistory::create([
            'requisition_id' => $requisition->id,
            'user_id' => $user->id,
            'action' => "Status changed from {$oldStatus} to {$newStatus}",
            'note' => $request->remarks,
        ]);

        // Dispatch event for email
        event(new RequisitionStatusChanged($requisition, $oldStatus, $newStatus, $request->remarks));

        return back()->with('success', 'Workflow updated.');
    }

    public function updateStatus(Request $request, $id)
    {
        // $req = Requisition::findOrFail($id);
        // $req->update([
        //     'status' => $request->status,
        //     'updated_by' => auth()->id()
        // ]);

        // return response()->json(['success' => true]);

        $req = Requisition::findOrFail($id);

        $old = $req->status;
        $new = $request->status;

        // Update status
        $req->update([
            'status' => $new,
        ]);

        // Insert log
        RequisitionLoghistory::create([
            'requisition_id' => $req->id,
            'user_id' => auth()->id(),
            'action_by' => $new,
            'action_type' => $new == 'Approved' ? 'APPROVED' : 'REJECTED',
            'created_by' => auth()->id(),
            'note' => "Status changed from {$old} to {$new}. Remarks: ".($request->comment ?? 'N/A'),
        ]);

        // SEND EMAIL TO EMPLOYEE (queued)
        Mail::to($req->requestedBy->email)
            ->queue(new RequisitionStatusMail($req, $new, $request->comment ?? null));

        // OPTIONAL: SEND EMAIL TO ADMIN (queued)
        Mail::to('admin@company.com')
            ->queue(new RequisitionStatusMail($req, $new));

        return response()->json(['success' => true]);
    }

    public function transportApprove($id)
    {
        $req = Requisition::findOrFail($id);

        if ($req->status != 2) {
            return response()->json(['status' => 'error', 'message' => 'Invalid workflow step']);
        }

        $req->status = 4; // Transport Office Approved
        $req->save();

        RequisitionLogHistory::create([
            'requisition_id' => $req->id,
            'user_id' => auth()->id(),
            'action' => 'Transport Approved',
        ]);

        return response()->json(['status' => 'success']);
    }

    public function transportReject($id)
    {
        $req = Requisition::findOrFail($id);

        if ($req->status != 2) {
            return response()->json(['status' => 'error', 'message' => 'Invalid workflow step']);
        }

        $req->status = 5; // Transport Office Rejected
        $req->save();

        RequisitionLogHistory::create([
            'requisition_id' => $req->id,
            'user_id' => auth()->id(),
            'action' => 'Transport Rejected',
            'note' => $request->note ?? null,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function adminApprove($id)
    {
        $req = Requisition::findOrFail($id);

        if ($req->status != 4) {
            return response()->json(['status' => 'error', 'message' => 'Invalid workflow step']);
        }

        $req->status = 6; // Final Approval
        $req->save();

        RequisitionLogHistory::create([
            'requisition_id' => $req->id,
            'user_id' => auth()->id(),
            'action' => 'Admin Final Approved',
        ]);

        $requisition->update([
            'approved_by_department' => auth()->id(),
            'department_approved_at' => now(),
            'status' => 'Pending Transport Approval',
        ]);

        sendNotification(
            $requisition->created_by,
            'Requisition Approved',
            "Your requisition request #{$requisition->id} has been approved.",
            'success',
            route('admin.requisition.show', $requisition->id)
        );

        return response()->json(['status' => 'success']);
    }

    public function adminReject($id)
    {
        $req = Requisition::findOrFail($id);

        if ($req->status != 4) {
            return response()->json(['status' => 'error', 'message' => 'Invalid workflow step']);
        }

        $req->status = 7; // Final Rejection
        $req->save();

        RequisitionLogHistory::create([
            'requisition_id' => $req->id,
            'user_id' => auth()->id(),
            'action' => 'Admin Final Rejected',
            'note' => $request->note ?? null,
        ]);

        $requisition->update([
            'approved_by_department' => auth()->id(),
            'department_approved_at' => now(),
            'status' => 'Rejected',
        ]);

        sendNotification(
            $requisition->created_by,
            'Requisition Rejected',
            "Your requisition request #{$requisition->id} was rejected.",
            'danger',
            route('admin.requisition.show', $requisition->id)
        );

        return response()->json(['status' => 'success']);
    }

    public function downloadPDF($id)
    {
        $requisition = Requisition::with([
            'employee',
            'department',
            'unit',
            'vehicle',
            'driver',
            'passengers.employee.department',
            'passengers.employee.unit',
            'approvedBy',
            'rejectedBy',
        ])->findOrFail($id);

        $pdf = PDF::loadView('admin.dashboard.requisition.pdf', compact('requisition'));

        return $pdf->download("requisition-{$requisition->requisition_number}.pdf");
    }

    public function getVehiclesByCapacity(Request $request)
    {
        Validator::make($request->all(), [
            'passenger_count' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'A valid passenger count is required.',
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            $passengerCount = $request->input('passenger_count');

            // Assuming the 'vehicles' table has a 'capacity' column
            $vehicles = Vehicle::where('capacity', '>=', $passengerCount)
                ->where('status', 1)
                ->orderBy('capacity', 'asc')
                ->get();

            if ($vehicles->isEmpty()) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'No vehicles found for the specified passenger count.',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'vehicles' => $vehicles,
            ]);

        } catch (\Exception $e) {
            \Log::error('Vehicle suggestion error: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred while fetching vehicle suggestions.',
            ], 500);
        }
    }

    public function getDriversByVehicle($vehicleId)
    {
        // Get the vehicle and find its associated driver via driver_id
        $vehicle = Vehicle::find($vehicleId);

        if ($vehicle && $vehicle->driver_id) {
            $drivers = Driver::where('id', $vehicle->driver_id)
                ->where('status', 1)
                ->get();
        } else {
            $drivers = collect();
        }

        return response()->json([
            'status' => 'success',
            'drivers' => $drivers,
        ]);
    }

    /**
     * Send notifications when requisition is created
     * Notifies: Department Head, Transport Manager, and Self
     */
    private function sendRequisitionCreatedNotifications(Requisition $requisition)
    {
        $notificationUsers = collect();
        $creatorUser = Auth::user();

        // 1. Get department head(s) for the same department
        $deptHeadUsers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Department Head', 'Super Admin', 'Admin']);
        })
            ->where('department_id', $requisition->department_id)
            ->where('id', '!=', $creatorUser->id)
            ->get();
        $notificationUsers = $notificationUsers->merge($deptHeadUsers);

        // 2. Get Transport Managers
        $transportUsers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Transport', 'Transport_Head', 'Super Admin', 'Admin']);
        })
            ->get();
        $notificationUsers = $notificationUsers->merge($transportUsers);

        // 3. Get the requester themselves (if they have a user account)
        if ($creatorUser) {
            $notificationUsers->push($creatorUser);
        }

        // Remove duplicates
        $notificationUsers = $notificationUsers->unique('id');

        Log::info('Requisition created notifications - target users count: '.$notificationUsers->count());
        foreach ($notificationUsers as $u) {
            Log::info('Notifying user ID: '.$u->id.', Email: '.$u->email);
        }

        try {
            if ($notificationUsers->isNotEmpty()) {
                foreach ($notificationUsers as $user) {
                    try {
                        $user->notify(new RequisitionCreated($requisition));
                    } catch (\Throwable $userError) {
                        \Log::warning('Failed to notify user '.$user->id.': '.$userError->getMessage());
                    }
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Notification send failed: '.$e->getMessage().' | File: '.$e->getFile().' | Line: '.$e->getLine());
        }
    }
}
