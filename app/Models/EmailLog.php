<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailLog extends Model
{
    use SoftDeletes;
    protected $fillable = ['requisition_id','recipient_email','subject','body','status','sent_at','status','created_by','updated_by'];
    public function requisition(){ return $this->belongsTo(Requisition::class); }
}
