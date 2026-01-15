<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\CompanyScope;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vehicle_name',
        'unit_id',
        'department_id',
        'license_plate',
        'vehicle_type_id',
        'driver_id',
        'vendor_id',
        'registration_date',
        'seat_capacity',
        'status',
        'availability_status',
        'created_by',
        'updated_by'
    ];

    /**
     * Vehicle belongs to a Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Vehicle belongs to a Driver
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    /**
     * Vehicle belongs to a Vehicle Type
     */
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    /**
     * Vehicle belongs to a Vendor
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * Vehicle belongs to a Unit
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

     public function requisitions(): HasMany
    {
        return $this->hasMany(Requisition::class, 'vehicle_id');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 1)
                    ->where('availability_status', 'available');
    }

    public function getAvailabilityStatusLabelAttribute()
    {
        return [
            'available' => 'Available',
            'Assigned'      => 'Assigned',
            'on_leave'  => 'Maintenance / Not Available'
        ][$this->availability_status] ?? 'Unknown';
    }

    public function getAvailabilityStatusBadgeAttribute()
    {
        return [
            'available' => 'success',   // green
            'busy'      => 'warning',   // yellow
            'on_leave'  => 'danger',    // red
        ][$this->availability_status] ?? 'secondary';
    }

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }



}
