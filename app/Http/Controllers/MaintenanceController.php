<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceSchedule;
use App\Models\MaintenanceRecord;
use App\Models\Vehicle;
use App\Models\Vendor;
use App\Models\MaintenanceCategory;
use App\Models\Employee;
use App\Models\MaintenanceType;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    public function index()
    {

    // return dd('maintenance index');
        // show due + history
        $dueSoon = MaintenanceSchedule::with('vehicle','maintenanceType','vendor')
            ->where('active', true)
            ->whereDate('next_due_date', '<=', now()->addDays(14)) // due in 2 weeks or overdue
            ->orderBy('next_due_date','asc')
            ->get();

        $records  = MaintenanceRecord::with('vehicle','maintenanceType','vendor')->latest()->limit(50)->get();

        return view('admin.dashboard.maintenance.index', compact('dueSoon','records'));
    }

    public function create() // schedule new maintenance
    {
        $vehicles = Vehicle::all();
        $types = MaintenanceType::all();
        $employees = Employee::all();
        $categories  = MaintenanceCategory::all();
        $vendors = Vendor::all();
        $schedules = MaintenanceSchedule::all();

        return view('admin.dashboard.maintenance.create', compact('vehicles','types','vendors','schedules', 'employees','categories'));
    }

    public function storeSchedule(Request $request)
    {
        $data = $request->validate([
            'vehicle_id'=>'required|exists:vehicles,id',
            'maintenance_type_id'=>'required|exists:maintenance_types,id',
            'vendor_id'=>'nullable|exists:maintenance_vendors,id',
            'next_due_date'=>'nullable|date',
            'due_km'=>'nullable|integer',
            'frequency'=>'nullable|string',
            'notes'=>'nullable|string',
        ]);

        MaintenanceSchedule::create($data);
        return redirect()->route('maintenance.index')->with('success','Maintenance scheduled.');
    }

    public function recordForm($scheduleId)
    {
        $schedule = MaintenanceSchedule::with('vehicle','type','vendor')->findOrFail($scheduleId);
        return view('maintenance.record', compact('schedule'));
    }

    public function recordMaintenance(Request $request, $scheduleId)
    {
        $schedule = MaintenanceSchedule::findOrFail($scheduleId);

        $data = $request->validate([
            'performed_at'=>'required|date',
            'start_km'=>'nullable|integer',
            'end_km'=>'nullable|integer',
            'cost'=>'nullable|numeric',
            'notes'=>'nullable|string',
            'vendor_id'=>'nullable|exists:maintenance_vendors,id',
            'receipt'=>'nullable|file|mimes:pdf,jpg,jpeg,png'
        ]);

        // file save
        if($request->hasFile('receipt')){
            $path = $request->file('receipt')->store('receipts','public');
            $data['receipt_path'] = $path;
        }

        $record = MaintenanceRecord::create(array_merge($data, [
            'schedule_id'=>$schedule->id,
            'vehicle_id'=>$schedule->vehicle_id,
            'maintenance_type_id'=>$schedule->maintenance_type_id,
            'performed_by'=>auth()->id()
        ]));

        // update schedule next_due_date logic (example: add frequency months if frequency is numeric months)
        if($schedule->frequency){
            // simple: if frequency e.g. '3 months' -> extract number
            if(preg_match('/(\d+)/', $schedule->frequency, $m)){
                $months = (int)$m[1];
                $schedule->next_due_date = Carbon::parse($data['performed_at'])->addMonths($months)->toDateString();
            }
        }
        // if due_km set, recalc next due km by adding the schedule.due_km delta if needed
        $schedule->save();

        return redirect()->route('maintenance.index')->with('success','Maintenance recorded.');
    }

    public function markScheduleInactive($id)
    {
        $s = MaintenanceSchedule::findOrFail($id);
        $s->active = false; $s->save();
        return back()->with('success','Schedule deactivated.');
    }

    public function dueList()
    {
        $due = MaintenanceSchedule::with('vehicle','type')->where('active', true)
                ->where(function($q){
                    $q->whereNotNull('next_due_date')->whereDate('next_due_date','<=', now()->addDays(7));
                })->get();
        return response()->json($due);
    }
}
