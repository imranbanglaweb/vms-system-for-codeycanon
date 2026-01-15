<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'request_no',
        'employee_id',
        'requested_date',
        'purpose',
        'from_location_id',
        'to_location_id',
        'travel_date',
        'travel_time',
        'return_date',
        'return_time',
        'passenger_count',
        'vehicle_type',
        'remarks',
        'status',

        'line_manager_id',
        'line_manager_approval_status',
        'line_manager_approval_date',
        'line_manager_remarks',

        'transport_officer_id',
        'transport_officer_approval_status',
        'transport_officer_approval_date',
        'transport_officer_remarks',

        'vehicle_id',
        'driver_id',

        'created_by',
        'updated_by'
    ];

    // ✅ Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function lineManager()
    {
        return $this->belongsTo(Employee::class, 'line_manager_id');
    }

    public function transportOfficer()
    {
        return $this->belongsTo(Employee::class, 'transport_officer_id');
    }

    public function passengers()
    {
        return $this->belongsToMany(Employee::class, 'travel_request_passengers', 'travel_request_id', 'employee_id')
                    ->withTimestamps();
    }

    public function logs()
    {
        return $this->hasMany(TravelRequestLog::class);
    }
}
