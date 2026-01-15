<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    // 'company_id',
    'unit_name',
    'unit_code',
    // 'location',
    // 'description',
    'status',
    'created_by',
    'updated_by'];

    // public function company() { return $this->belongsTo(Company::class); }
    // public function departments() { return $this->hasMany(Department::class); }
    // public function locations() { return $this->hasMany(Location::class); }
    // public function employees() { return $this->hasMany(Employee::class); }
    // public function vehicles() { return $this->hasMany(Vehicle::class); }
}
