<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogHistory extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','action_type','module_name','reference_id','old_values','new_values','ip_address','user_agent','remarks','status','created_by','updated_by'];
    public function user(){ return $this->belongsTo(Employee::class,'user_id'); }
}
