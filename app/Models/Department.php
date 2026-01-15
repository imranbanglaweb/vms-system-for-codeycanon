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
        'description',
        'status',
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

}
