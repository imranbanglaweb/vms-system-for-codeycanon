<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use NotificationChannels\WebPush\PushSubscription as BasePushSubscription;
class PushSubscription extends BasePushSubscription
{
    protected $table = 'push_subscriptions'; // ADD THIS LINE

    protected $fillable = [
        'user_id',
        'endpoint',
        'p256dh',
        'auth',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
