<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequisitionApproval extends Model
{
    use SoftDeletes;
    protected $fillable = ['requisition_id','approved_by','approval_level','approval_status','remarks','created_by','updated_by'];
    public function requisition(){ return $this->belongsTo(Requisition::class); }
    public function approver(){ return $this->belongsTo(Employee::class,'approved_by'); }
}
