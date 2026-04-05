<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'price', 'billing_cycle',
        'vehicle_limit', 'user_limit', 'driver_limit',
        'monthly_reports', 'monthly_alerts',
        'features', 'is_trial', 'trial_days',
        'is_popular', 'is_active', 'last_updated_at',
        'recommended_for', 'display_order'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'is_trial' => 'boolean',
        'trial_days' => 'integer',
        'vehicle_limit' => 'integer',
        'user_limit' => 'integer',
        'driver_limit' => 'integer',
        'monthly_reports' => 'integer',
        'monthly_alerts' => 'integer',
        'last_updated_at' => 'datetime',
        'display_order' => 'integer',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }

    public function getFeaturesAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        
        if (is_array($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }
        
        return [];
    }
}
