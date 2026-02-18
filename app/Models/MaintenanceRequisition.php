<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequisition extends Model
{
    protected $fillable = [
        'requisition_no',
        'requisition_type',
        'priority',
        'employee_id',
        'vehicle_id',
        'maintenance_type_id',
        'vendor_id',
        'maintenance_date',
        'service_title',
        'charge_bear_by',
        'charge_amount',
        'remarks',
        'total_parts_cost',
        'total_cost',
        'status',
        'department_status',
        'department_approved_by',
        'department_approved_at',
        'department_remarks',
        'transport_status',
        'transport_approved_by',
        'transport_approved_at',
        'transport_remarks',
        'approved_by',
        'approved_at',
        'approval_remarks',
        'created_by',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'approved_at' => 'datetime',
        'charge_amount' => 'decimal:2',
        'total_parts_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function maintenanceType()
    {
        return $this->belongsTo(MaintenanceType::class);
    }

    public function vendor()
    {
        return $this->belongsTo(MaintenanceVendor::class, 'vendor_id');
    }

    public function items()
    {
        return $this->hasMany(MaintenanceRequisitionItem::class, 'requisition_id');
    }
    
    public function getRequestedByNameAttribute()
    {
        return $this->requestedBy->name ?? 'Unknown';
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopePendingApproval($query)
    {
        return $query->where('status', 'Pending Approval');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }
}
