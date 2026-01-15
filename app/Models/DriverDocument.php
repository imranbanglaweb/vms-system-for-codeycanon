<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverDocument extends Model
{
    use SoftDeletes;
    protected $fillable = ['driver_id','document_type','document_number','file_path','issue_date','expiry_date','remarks','status','created_by','updated_by'];
    public function driver(){ return $this->belongsTo(Driver::class); }
}
