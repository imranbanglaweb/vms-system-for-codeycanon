<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['company_name','company_code','unit_id','address','contact_number','email','remarks','status','created_by','updated_by'];

    public function units() { return $this->hasMany(Unit::class); }
    public function unit() { return $this->belongsTo(Unit::class, 'unit_id'); }
    public function departments() { return $this->hasMany(Department::class); }
    public function employees() { return $this->hasMany(Employee::class); }
    public function vehicles() { return $this->hasMany(Vehicle::class); }
    public function users(){ return $this->hasMany(User::class);}
    public function subscription(){ return $this->hasOne(Subscription::class);}

}
