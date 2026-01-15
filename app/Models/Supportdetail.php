<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supportdetail extends Model
{
 	use HasFactory;
     protected $table = 'supportdetails';

        protected $fillable = [
   		'id',
        'support_id',
        'category_id',
        'employee_id',
        'assigned_id',
        'issue_type_id',
        'assigned_id',
        'solved_process_id',
        'support_type_id',
        'support_status',
        'status_changed_by',
        'changed_date',
        'remarks',
        'created_by',
        'created_by',
    ];
}
