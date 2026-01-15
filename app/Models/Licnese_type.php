<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Licnese_type extends Model
{
    use SoftDeletes;
    protected $fillable = ['type_name','description','status','created_by','updated_by'];
    public function drivers(){ return $this->hasMany(Driver::class,'license_type_id'); }
}

