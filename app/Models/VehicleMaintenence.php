<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleMaintenence extends Model
{
    use SoftDeletes;
    protected $fillable = ['vehicle_id','maintenance_date','maintenance_type','service_provider','cost','invoice_number','attachment','remarks','status','created_by','updated_by'];
    public function vehicle(){ return $this->belongsTo(Vehicle::class); }
}