<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpsTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'trip_sheet_id',
        'latitude',
        'longitude',
        'speed',
        'heading',
        'altitude',
        'battery_level',
        'signal_strength',
        'device_id',
        'device_type',
        'app_version',
        'status',
        'recorded_at',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'speed' => 'decimal:2',
        'heading' => 'decimal:2',
        'altitude' => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function tripSheet()
    {
        return $this->belongsTo(TripSheet::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeMoving($query)
    {
        return $query->where('status', 'moving');
    }

    public function scopeForVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    public function scopeForTrip($query, $tripSheetId)
    {
        return $query->where('trip_sheet_id', $tripSheetId);
    }

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('recorded_at', [$startDate, $endDate]);
    }

    public function scopeLatestForVehicle($query)
    {
        return $query->whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')
                ->from('gps_tracks')
                ->groupBy('vehicle_id');
        });
    }

    public static function getLatestPositions()
    {
        return self::select('gps_tracks.*')
            ->selectRaw('ROW_NUMBER() OVER (PARTITION BY vehicle_id ORDER BY recorded_at DESC) as rn')
            ->having('rn', 1)
            ->with(['vehicle', 'driver']);
    }

    public static function getVehiclePath($vehicleId, $startDate, $endDate)
    {
        return self::where('vehicle_id', $vehicleId)
            ->whereBetween('recorded_at', [$startDate, $endDate])
            ->orderBy('recorded_at')
            ->get();
    }
}