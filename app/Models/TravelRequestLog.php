<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelRequestLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'travel_request_id',
        'action_type',          // e.g., 'created', 'line_manager_approved', 'officer_approved', 'rejected', 'vehicle_assigned'
        'action_by',            // employee or officer ID
        'remarks',              // optional comments
        'previous_status',      // before action
        'current_status',       // after action
        'action_date',
        'ip_address',
        'device_info',

        'status',
        'created_by',
        'updated_by'
    ];

    // ✅ Relationships
    public function travelRequest()
    {
        return $this->belongsTo(TravelRequest::class);
    }

    public function actor()
    {
        return $this->belongsTo(Employee::class, 'action_by');
    }
}
