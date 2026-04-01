<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsDevice extends Model
{
    protected $fillable = [
        'vehicle_id',
        'device_name',
        'device_type',
        'imei_number',
        'sim_number',
        'protocol',
        'server_host',
        'server_port',
        'is_active',
        'installation_date',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'installation_date' => 'date',
    ];

    /**
     * Get the vehicle that owns this GPS device
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get GPS tracks for this device
     */
    public function gpsTracks()
    {
        return $this->hasMany(GpsTrack::class, 'device_id', 'imei_number');
    }

    /**
     * Get latest location
     */
    public function latestLocation()
    {
        return $this->hasOne(GpsTrack::class, 'device_id', 'imei_number')
            ->latest('recorded_at');
    }

    /**
     * Check if device is online (received data in last 5 minutes)
     */
    public function isOnline()
    {
        if (!$this->latestLocation) {
            return false;
        }
        
        return $this->latestLocation->recorded_at->diffInMinutes(now()) < 5;
    }
}