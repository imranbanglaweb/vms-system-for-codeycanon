<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowLog extends Model
{
    protected $fillable = [
        'requisition_id',
        'changed_by',
        'old_status',
        'new_status',
        'remarks',
         'action',
    ];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
