<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    protected $fillable = [
        'title', 
        'vehicle_id',
        'maintenance_type_id',
        'vendor_id',
        'next_due_date',
        'due_km',
        'frequency',
        'scheduled_at', 
        'created_by', 
        'notes','active'
    ];

    public function vehicle(){ return $this->belongsTo(Vehicle::class); }
    public function type(){ return $this->belongsTo(MaintenanceType::class, 'maintenance_type_id'); }
    public function vendor(){ return $this->belongsTo(Vendor::class); }
    public function records(){ return $this->hasMany(MaintenanceRecord::class, 'schedule_id'); }
}
