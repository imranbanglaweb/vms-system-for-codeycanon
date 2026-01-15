<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueregisterLog extends Model
{
    // use HasFactory;
     protected $table = 'issueregister_logs';

        protected $fillable = [
        'id',
        'issue_id',
        'support_status',
        'status_changed_by',
        'changed_date',
        'remarks',
        'created_by',
        'created_by',
    ];
}
