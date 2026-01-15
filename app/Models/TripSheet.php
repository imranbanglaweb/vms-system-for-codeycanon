<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripSheet extends Model
{
    protected $fillable = [
        'trip_number',
        'requisition_id',
        'vehicle_id',
        'driver_id',
        'start_date',
        'trip_start_time',
        'start_meter',
        'start_location',
        'end_date',
        'trip_end_time',
        'closing_meter',
        'end_location',
        'start_km',
        'end_km',
        'total_km',
        'remarks',
        'status'
    ];


    public function requisition() { return $this->belongsTo(Requisition::class); }
    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function driver() { return $this->belongsTo(Driver::class); }
}
