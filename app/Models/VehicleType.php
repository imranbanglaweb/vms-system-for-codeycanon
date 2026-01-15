<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleType extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','description','status','created_by','updated_by'];
    public function vehicles(){ return $this->hasMany(Vehicle::class); }

    
}
