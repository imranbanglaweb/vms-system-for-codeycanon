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
        'is_popular', 'is_active'
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
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
