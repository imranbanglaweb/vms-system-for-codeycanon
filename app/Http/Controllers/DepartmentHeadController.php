<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\DepartmentHeadAssignedMail;

class DepartmentHeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display department head management page
     */
    public function index()
    {
        $departments = Department::with(['headEmployee', 'unit'])
            ->orderBy('department_name')
            ->get();

        return view('admin.dashboard.department_head.index', compact('departments'));
    }

    /**
     * Store department head assignment
     */
    public function store(Request $request)
    {
        Log::info('DepartmentHeadController.store: Request received', [
            'department_id' => $request->department_id,
            'head_type' => $request->head_type,
            'head_employee_id' => $request->head_employee_id,
            'has_notification' => $request->has('send_notification'),
        ]);
        
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'head_type' => 'required|in:employee,manual',
            'head_employee_id' => 'required_if:head_type,employee|exists:employees,id',
            'head_name' => 'required_if:head_type,manual|string|max:100',
            'head_email' => 'required_if:head_type,manual|email|max:150',
            'send_notification' => 'nullable|in:1',
        ]);

        $department = Department::findOrFail($request->department_id);

        // Prepare update data
        $updateData = [
            'updated_by' => Auth::id() ?? 1,
        ];

        if ($request->head_type === 'employee') {
            $employee = Employee::findOrFail($request->head_employee_id);
            
            $updateData['head_employee_id'] = $employee->id;
            $updateData['head_email'] = $employee->email;
            $updateData['head_name'] = $employee->name;
        } else {
            $updateData['head_employee_id'] = null;
            $updateData['head_email'] = $request->head_email;
            $updateData['head_name'] = $request->head_name;
        }

        // Update department
        $department->update($updateData);

        Log::info('DepartmentHeadController.store: Success', [
            'department_id' => $department->id,
            'head_employee_id' => $updateData['head_employee_id'] ?? null,
        ]);

        // Send notification email if requested
        if ($request->send_notification == '1') {
            $this->sendNotificationEmail($department);
        }

        Log::info('DepartmentHeadController: Department head assigned', [
            'department_id' => $department->id,
            'department_name' => $department->department_name,
            'head_type' => $request->head_type,
            'head_name' => $updateData['head_name'],
            'notification_sent' => $request->send_notification == '1',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Department head assigned successfully!',
        ]);
    }

    /**
     * Send notification email to department head
     */
    public function sendNotification(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
        ]);

        $department = Department::findOrFail($request->department_id);

        if (!$this->sendNotificationEmail($department)) {
            return redirect()->back()->with('error', 'Failed to send notification email. Please check email configuration.');
        }

        return redirect()->back()->with('success', 'Notification email sent successfully to department head!');
    }

    /**
     * Send notification email helper method
     */
    private function sendNotificationEmail(Department $department): bool
    {
        $headEmail = $department->head_email;
        
        if (empty($headEmail)) {
            Log::warning('DepartmentHeadController: No email address found for department head', [
                'department_id' => $department->id,
            ]);
            return false;
        }

        try {
            Mail::to($headEmail)->send(new DepartmentHeadAssignedMail($department));
            
            Log::info('DepartmentHeadController: Notification email sent', [
                'department_id' => $department->id,
                'email' => $headEmail,
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('DepartmentHeadController: Failed to send notification email', [
                'department_id' => $department->id,
                'email' => $headEmail,
                'error' => $e->getMessage(),
            ]);
            
            return false;
        }
    }

    /**
     * Remove department head assignment
     */
    public function remove(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
        ]);

        $department = Department::findOrFail($request->department_id);

        $headName = $department->head_name;
        
        $department->update([
            'head_employee_id' => null,
            'head_email' => null,
            'head_name' => null,
            'updated_by' => Auth::id() ?? 1,
        ]);

        Log::info('DepartmentHeadController: Department head removed', [
            'department_id' => $department->id,
            'department_name' => $department->department_name,
            'previous_head' => $headName,
        ]);

        return redirect()->back()->with('success', 'Department head removed successfully!');
    }

    /**
     * Get employees by department (API endpoint for dropdown)
     */
    public function getEmployeesByDepartment(Request $request, $departmentId)
    {
        Log::info('DepartmentHeadController.getEmployeesByDepartment called', [
            'departmentId' => $departmentId,
            'selected_employee_id' => $request->query('selected_employee_id'),
        ]);
        
        $selectedEmployeeId = $request->query('selected_employee_id');
        
        // Fetch ALL active employees - department head can be from any department
        $employees = Employee::where('status', 'Active')
            ->orderBy('name')
            ->get(['id', 'name', 'designation', 'email']);
        
        Log::info('DepartmentHeadController.getEmployeesByDepartment: Found employees', [
            'count' => $employees->count(),
        ]);
        
        // If there's a selected employee not in the list, add them
        if ($selectedEmployeeId) {
            $selectedEmployee = Employee::where('id', $selectedEmployeeId)->first();
            if ($selectedEmployee && !$employees->contains('id', $selectedEmployeeId)) {
                $employees->push($selectedEmployee);
            }
        }
        
        return response()->json($employees);
    }
}
