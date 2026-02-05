<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'status',
        'fuel_used'
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'trip_start_time' => 'datetime:Y-m-d H:i:s',
        'trip_end_time' => 'datetime:Y-m-d H:i:s',
        'start_meter' => 'decimal:2',
        'closing_meter' => 'decimal:2',
        'start_km' => 'decimal:2',
        'end_km' => 'decimal:2',
        'total_km' => 'decimal:2',
    ];

    // Status constants
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    /**
     * Get the requisition that owns the trip sheet.
     */
    public function requisition(): BelongsTo
    {
        return $this->belongsTo(Requisition::class);
    }

    /**
     * Get the vehicle assigned to the trip.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the driver assigned to the trip.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Generate a unique trip number.
     */
    public static function generateTripNumber(): string
    {
        $prefix = 'TRIP-';
        $date = now()->format('Ymd');
        $uniqueId = strtoupper(uniqid());
        
        return $prefix . $date . '-' . $uniqueId;
    }

    /**
     * Check if the trip is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    /**
     * Check if the trip is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if the trip is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Get formatted status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            default => 'Unknown',
        };
    }

    /**
     * Get formatted start date.
     */
    public function getFormattedStartDateAttribute(): string
    {
        return $this->start_date ? $this->start_date->format('d M Y') : '-';
    }

    /**
     * Get formatted end date.
     */
    public function getFormattedEndDateAttribute(): string
    {
        return $this->end_date ? $this->end_date->format('d M Y') : '-';
    }

    /**
     * Get formatted total KM.
     */
    public function getFormattedTotalKmAttribute(): string
    {
        return $this->total_km ? number_format($this->total_km, 2) . ' KM' : '0 KM';
    }

    /**
     * Scope a query to only include in-progress trips.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    /**
     * Scope a query to only include completed trips.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include cancelled trips.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $from, $to)
    {
        return $query->whereDate('start_date', '>=', $from)
                    ->whereDate('start_date', '<=', $to);
    }

    /**
     * Scope a query to filter by vehicle.
     */
    public function scopeForVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    /**
     * Scope a query to filter by driver.
     */
    public function scopeForDriver($query, $driverId)
    {
        return $query->where('driver_id', $driverId);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate trip number on creation
        static::creating(function ($trip) {
            if (empty($trip->trip_number)) {
                $trip->trip_number = self::generateTripNumber();
            }
        });
    }
}
