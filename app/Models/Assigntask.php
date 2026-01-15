<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigntask extends Model
{
    use HasFactory;
       protected $table = 'assigntasks';
    // protected $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'issue_register_id',
        'assign_date',
        'assign_task_fron',
        'assign_task_to',
        'assigntasks_status',
        'assigntasks_oder',
        'remarks',
        'status',
        'created_by',
    ];
}
