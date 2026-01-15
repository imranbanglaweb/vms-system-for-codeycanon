<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    protected $fillable = [
        'schedule_id','vehicle_id','maintenance_type_id','vendor_id',
        'performed_at','start_km','end_km','cost','notes','receipt_path','performed_by'
    ];

    public function schedule(){ return $this->belongsTo(MaintenanceSchedule::class); }
    public function vehicle(){ return $this->belongsTo(Vehicle::class); }
    public function type(){ return $this->belongsTo(MaintenanceType::class, 'maintenance_type_id'); }
    public function vendor(){ return $this->belongsTo(Vendor::class); }
}
