<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Licnese_type;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'driver_code',
        'name',
        'phone',
        'driver_name',
        'license_number',
        'license_no',
        'license_type',
        'license_type_id',
        'license_expiry',
        'nid_no',
        'address',
        'photo',
        'department_id',
        'unit_id',
        'availability_status',
        'status',
        'created_by',
        'updated_by'
    ];

    // ✅ Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function licenseType()
    {
        return $this->belongsTo(Licnese_type::class, 'license_type_id');
    }

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function travelRequests()
    {
        return $this->belongsToMany(TravelRequest::class, 'driver_travel_request')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class, 'driver_id', 'id');
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
            'on_leave'  => 'On Leave'
        ][$this->availability_status] ?? 'Unknown';
    }

    public function getAvailabilityStatusBadgeAttribute()
    {
        return [
            'available' => 'success',
            'Assigned'      => 'warning',
            'on_leave'  => 'danger',
        ][$this->availability_status] ?? 'secondary';
    }

    public function unit() {
    return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }

  




}
