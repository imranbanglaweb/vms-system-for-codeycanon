<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\CompanyScope;

class AIMaintenanceAlert extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ai_maintenance_alerts';

    protected $fillable = [
        'vehicle_id',
        'created_by',
        'alert_type',
        'priority',
        'status',
        'recommendation',
        'estimated_cost',
        'urgency_level',
        'ai_analysis',
        'notes',
        'scheduled_date',
        'company_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }

    protected $casts = [
        'ai_analysis' => 'array',
        'estimated_cost' => 'decimal:2',
        'scheduled_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_ACKNOWLEDGED = 'acknowledged';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_DISMISSED = 'dismissed';

    /**
     * Priority constants
     */
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_CRITICAL = 'critical';

    /**
     * Alert type constants
     */
    const ALERT_OIL_CHANGE = 'oil_change';
    const ALERT_TIRE_REPLACEMENT = 'tire_replacement';
    const ALERT_BRAKE_SERVICE = 'brake_service';
    const ALERT_BATTERY = 'battery';
    const ALERT_FILTER = 'filter';
    const ALERT_TRANSMISSION = 'transmission';
    const ALERT_SUSPENSION = 'suspension';
    const ALERT_OTHER = 'other';

    /**
     * Relationships
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_ACKNOWLEDGED, self::STATUS_SCHEDULED]);
    }

    public function scopeCritical($query)
    {
        return $query->where('priority', self::PRIORITY_CRITICAL);
    }

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', [self::PRIORITY_CRITICAL, self::PRIORITY_HIGH]);
    }

    public function scopeByVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    public function scopeByAlertType($query, $alertType)
    {
        return $query->where('alert_type', $alertType);
    }

    /**
     * Get all available statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_ACKNOWLEDGED => 'Acknowledged',
            self::STATUS_SCHEDULED => 'Scheduled',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_DISMISSED => 'Dismissed',
        ];
    }

    /**
     * Get all available priorities
     */
    public static function getPriorities()
    {
        return [
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_MEDIUM => 'Medium',
            self::PRIORITY_HIGH => 'High',
            self::PRIORITY_CRITICAL => 'Critical',
        ];
    }

    /**
     * Get all available alert types
     */
    public static function getAlertTypes()
    {
        return [
            self::ALERT_OIL_CHANGE => 'Oil Change',
            self::ALERT_TIRE_REPLACEMENT => 'Tire Replacement',
            self::ALERT_BRAKE_SERVICE => 'Brake Service',
            self::ALERT_BATTERY => 'Battery',
            self::ALERT_FILTER => 'Filter',
            self::ALERT_TRANSMISSION => 'Transmission',
            self::ALERT_SUSPENSION => 'Suspension',
            self::ALERT_OTHER => 'Other',
        ];
    }

    /**
     * Get priority badge color
     */
    public function getPriorityBadgeColor()
    {
        return match($this->priority) {
            self::PRIORITY_CRITICAL => 'danger',
            self::PRIORITY_HIGH => 'warning',
            self::PRIORITY_MEDIUM => 'info',
            default => 'success',
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColor()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_ACKNOWLEDGED => 'info',
            self::STATUS_SCHEDULED => 'primary',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_DISMISSED => 'secondary',
            default => 'dark',
        };
    }
}
