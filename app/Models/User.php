<?php
  
namespace App\Models;
  
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use NotificationChannels\WebPush\HasPushSubscriptions;
  
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasPushSubscriptions;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'user_image',
        'password',
        'role_id',
        'user_type',
        'user_name',
        'employee_id',
        'cell_phone',
        'unit_id',
        'company_id',
        'push_subscription',
        'department_id',
        'location_id',
    ];
  
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
  
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
  
    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        // Log the email routing
        \Log::info('Routing mail notification', [
            'user_id' => $this->id,
            'email' => $this->email,
            'notification' => get_class($notification)
        ]);
        
        if (empty($this->email)) {
            \Log::warning('User has no email address', ['user_id' => $this->id]);
            return null;
        }
        
        return [$this->email => $this->name];
    }
  
    // App\Models/User.php
    public function pushSubscriptions()
    {
        return $this->hasMany(\NotificationChannels\WebPush\PushSubscription::class);
    }
  
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
  
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
  
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
  
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
  
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
  
}
