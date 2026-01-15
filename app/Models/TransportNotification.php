<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportNotification extends Model
{
      use SoftDeletes;
    protected $fillable = ['user_id','title','message','type','channel','reference_table','reference_id','read_at','is_sent','status','created_by','updated_by'];
    public function user(){ return $this->belongsTo(Employee::class,'user_id'); }
}


