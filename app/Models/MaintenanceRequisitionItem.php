<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequisitionItem extends Model
{
     protected $fillable = [
        'requisition_id',
        'category_id',
        'item_name',
        'qty',
        'unit_price',
        'total_price',
        'created_by',
    ];

    public function requisition()
    {
        return $this->belongsTo(MaintenanceRequisition::class);
    }

    public function category()
    {
        return $this->belongsTo(MaintenanceCategory::class, 'category_id');
    }
    
}
