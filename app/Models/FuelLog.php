<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'trip_id',
        'fuel_date',
        'fuel_type',
        'quantity',
        'cost',
        'location',
        'odometer_reading',
        'receipt_number',
        'receipt_image',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fuel_date' => 'date',
        'quantity' => 'decimal:2',
        'cost' => 'decimal:2',
        'odometer_reading' => 'decimal:2',
    ];

    /**
     * Get the driver that owns the fuel log
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get the vehicle associated with the fuel log
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the trip associated with the fuel log
     */
    public function trip()
    {
        return $this->belongsTo(Requisition::class, 'trip_id');
    }
}
