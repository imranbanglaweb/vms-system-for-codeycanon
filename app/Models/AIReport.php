<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AIReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ai_reports';

    protected $fillable = [
        'created_by',
        'report_type',
        'title',
        'description',
        'status',
        'report_period_from',
        'report_period_to',
        'filter_criteria',
        'ai_summary',
        'ai_findings',
        'ai_recommendations',
        'ai_analysis',
        'raw_data',
        'error_message',
        'file_path',
        'total_records',
        'company_id',
    ];

    protected $casts = [
        'filter_criteria' => 'array',
        'ai_summary' => 'array',
        'ai_findings' => 'array',
        'ai_recommendations' => 'array',
        'ai_analysis' => 'array',
        'raw_data' => 'array',
        'report_period_from' => 'datetime',
        'report_period_to' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_GENERATING = 'generating';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_ARCHIVED = 'archived';

    /**
     * Report type constants
     */
    const TYPE_MAINTENANCE = 'maintenance';
    const TYPE_FUEL_EFFICIENCY = 'fuel_efficiency';
    const TYPE_DRIVER_PERFORMANCE = 'driver_performance';
    const TYPE_FLEET_HEALTH = 'fleet_health';
    const TYPE_COST_ANALYSIS = 'cost_analysis';
    const TYPE_CUSTOM = 'custom';

    /**
     * Relationships
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scopes
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeGenerating($query)
    {
        return $query->where('status', self::STATUS_GENERATING);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('report_type', $type);
    }

    public function scopeByCreator($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    /**
     * Get all available report types
     */
    public static function getReportTypes()
    {
        return [
            self::TYPE_MAINTENANCE => 'Maintenance Analysis',
            self::TYPE_FUEL_EFFICIENCY => 'Fuel Efficiency Report',
            self::TYPE_DRIVER_PERFORMANCE => 'Driver Performance Report',
            self::TYPE_FLEET_HEALTH => 'Fleet Health Report',
            self::TYPE_COST_ANALYSIS => 'Cost Analysis Report',
            self::TYPE_CUSTOM => 'Custom Report',
        ];
    }

    /**
     * Get all available statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_GENERATING => 'Generating',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_ARCHIVED => 'Archived',
        ];
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColor()
    {
        return match($this->status) {
            self::STATUS_GENERATING => 'warning',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_FAILED => 'danger',
            self::STATUS_ARCHIVED => 'secondary',
            default => 'dark',
        };
    }

    /**
     * Check if report is ready for download
     */
    public function isReady(): bool
    {
        return $this->status === self::STATUS_COMPLETED && !empty($this->file_path);
    }

    /**
     * Check if report generation is in progress
     */
    public function isGenerating(): bool
    {
        return $this->status === self::STATUS_GENERATING;
    }
}
