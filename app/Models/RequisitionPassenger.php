<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequisitionPassenger extends Model
{
    use SoftDeletes;
    protected $fillable = ['requisition_id','employee_id','company_id','unit_id','department_id','pickup_point','drop_point','status','remarks','created_by','updated_by'];
    public function requisition(){ return $this->belongsTo(Requisition::class); }
    public function employee(){ return $this->belongsTo(Employee::class); }

    
}
