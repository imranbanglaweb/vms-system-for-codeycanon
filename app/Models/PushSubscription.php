<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use NotificationChannels\WebPush\PushSubscription as BasePushSubscription;
class PushSubscription extends BasePushSubscription
{
    protected $table = 'push_subscriptions';

    protected $fillable = [
        'user_id',
        'endpoint',
        'public_key',
        'auth_token',
        'content_encoding',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
