<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailLog extends Model
{
    use SoftDeletes;

    protected $fillable = ['requisition_id','recipient_email','subject','body','status','error_message','sent_at','created_by','updated_by'];

    // Email status constants
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';
    public const STATUS_PENDING = 'pending';

    /**
     * Get all available status types
     */
    public static function getStatusTypes(): array
    {
        return [
            self::STATUS_SENT => 'Sent',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_PENDING => 'Pending',
        ];
    }

    /**
     * Scope for sent emails
     */
    public function scopeSent($query)
    {
        return $query->where('status', self::STATUS_SENT);
    }

    /**
     * Scope for failed emails
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    /**
     * Relationship with Requisition
     */
    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }
}
