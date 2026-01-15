<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;
    protected $fillable = ['unit_id','location_name','location_code','address','city','district','country','latitude','longitude','remarks','status','created_by','updated_by'];
    public function unit(){ return $this->belongsTo(Unit::class); }
}
