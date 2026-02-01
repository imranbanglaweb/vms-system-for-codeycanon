<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'unit_id',
        'department_name',
        'department_code',
        'department_short_name',
        'location',
        'description',
        'status',
        'head_employee_id',
        'head_email',
        'head_name',
        'created_by',
        'updated_by'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

      public function requisitions(): HasMany
    {
        return $this->hasMany(Requisition::class, 'department_id');
    }

    public function employees()
        {
             return $this->hasMany(Employee::class, 'department_id');
        }

    /**
     * Get the department head employee
     */
    public function headEmployee()
    {
        return $this->belongsTo(Employee::class, 'head_employee_id');
    }

    /**
     * Get department head email (fallback logic)
     */
    public function getHeadEmailAttribute()
    {
        // First try to get from head_employee relationship
        if ($this->headEmployee && !empty($this->headEmployee->email)) {
            return $this->headEmployee->email;
        }
        
        // Return stored head_email if exists
        return $this->attributes['head_email'] ?? null;
    }

    /**
     * Get department head name (fallback logic)
     */
    public function getHeadNameAttribute()
    {
        // First try to get from head_employee relationship
        if ($this->headEmployee && !empty($this->headEmployee->name)) {
            return $this->headEmployee->name;
        }
        
        // Return stored head_name if exists
        return $this->attributes['head_name'] ?? null;
    }

}
