<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Department;
use App\Models\tasktitle;
class IssueRegister extends Model
{
    use HasFactory;

       protected $table = 'issue_registers';

        protected $fillable = [
        'id',
        'task_id',
        'category_id',
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

        public function categoryName(){

        return $this->belongsTo(Category::class,'category_id');
    }
        public function employeeName(){

        return $this->belongsTo(Employee::class,'assigned_to');
    }
       public function departmentName(){

           return $this->belongsTo(Department::class,'department_id');

    }
       public function titleName(){

           return $this->belongsTo(tasktitle::class,'title');

    }




}
