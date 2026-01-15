<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requisition extends Model
{
    use SoftDeletes;
    protected $fillable = [
      'requested_by',
      'company_id',
      'unit_id',
      'department_id',
      'from_location',
      'to_location',
      'purpose',
      'travel_date',
      'travel_time',
      'return_date',
      'vehicle_id',
      'vehicle_type',
      'requisition_number',
      'number_of_passenger',
      'driver_id',
      'requisition_date',
      'status',
      'approval_level_1_by',
      'approval_level_1_date',
      'approval_level_2_by',
      'approval_level_2_date',
      'total_passenger_count',
      'created_by',
      'updated_by'
    ];

    
public const STATUS_PENDING = 'Pending';
public const STATUS_DEPT_APPROVED = 'Dept_Approved';
public const STATUS_TRANSPORT_APPROVED = 'Transport_Approved';
public const STATUS_GM_APPROVED = 'GM_Approved';
public const STATUS_REJECTED = 'Rejected';
public const STATUS_COMPLETED = 'Completed';


    protected $casts = [
      'travel_date'=>'date','travel_time'=>'datetime','return_date'=>'datetime',
      'approval_level_1_date'=>'datetime','approval_level_2_date'=>'datetime'
    ];

    public function creator(){ return $this->belongsTo(Employee::class,'requested_by'); }
    public function passengers(){ return $this->hasMany(RequisitionPassenger::class); }
    public function approvals(){ return $this->hasMany(RequisitionApproval::class); }
    public function vehicle(){ return $this->belongsTo(Vehicle::class); }
    public function driver(){ return $this->belongsTo(Driver::class); }
    public function logs(){ return $this->hasMany(RequisitionLogHistory::class); }
    public function notifications(){ return $this->hasMany(Notification::class); }
    public function requestedBy(){return $this->belongsTo(Employee::class, 'requested_by', 'id');}
    public function departmentHead()
    {
        return $this->belongsTo(Employee::class, 'approved_by_department');
    }

    public function transportAdmin()
    {
        return $this->belongsTo(User::class, 'transport_admin_id'); 
    }
    public function workflowLogs()
{
    return $this->hasMany(WorkflowLog::class);
}
 // Badge Color Helper
        public function statusBadgeColor()
        {
            return [
                'Pending' => 'warning',
                'Dept_Approved' => 'info',
                'Transport_Approved' => 'primary',
                'GM_Approved' => 'success',
                'Rejected' => 'danger',
                'Completed' => 'dark',
            ][$this->status] ?? 'secondary';
        }
            
      // Relationship with Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

      // Relationship with Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

     // Relationship with Employee
   public function employee()
    {
        // 'requested_by' is the foreign key in requisitions table
        return $this->belongsTo(Employee::class, 'requested_by');
    }

    // assigned vehicle/driver
public function assignedVehicle() { return $this->belongsTo(\App\Models\Vehicle::class,'assigned_vehicle_id'); }
public function assignedDriver() { return $this->belongsTo(\App\Models\Driver::class,'assigned_driver_id'); }


public function vehicleType() {
    return $this->belongsTo(VehicleType::class, 'vehicle_type');
}
    

    
}
