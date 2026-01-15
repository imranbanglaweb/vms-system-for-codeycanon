<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignprojectDepartment extends Model
{
    protected $table = 'assignproject_departments';
    // protected $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'unit_id',
        'project_location_id',
        'department_id',
        'oder',
        'remarks',
        'status',
        'created_by',
    ];
}
