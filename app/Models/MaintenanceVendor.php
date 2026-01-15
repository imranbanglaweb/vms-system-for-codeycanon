<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceVendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'contact_person', 
        'email', 
        'phone', 
        'address',
        'created_by'
    ];
}
