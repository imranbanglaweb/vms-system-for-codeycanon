<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Taskfileimport extends Model
{
    use HasFactory;
       protected $table = 'issue_registers';
        protected $fillable = [
        'id',
        'task_id',
        'category_id',
        'quantity',
        'issue_date',
        'raised_by',
        'assigned_to',
        'employee_id',
        'support_id',
        'unit_id',
        'company_id',
        'department_id',
        'location_id',
        'company_id',
        'issue_come_from',
        'support_id',
        'issue_type_id',
        'title',
        'issue_status',
        'task_details',
        'task_completed_date',
        'task_start_date',
        'task_due_date',
        'assign_task_status',
        'solved_process_id',
        'status_changed_by',
        'changed_date',
        'remarks',
        'created_by',
        'created_by',
    ];

        
}
