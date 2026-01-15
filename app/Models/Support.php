<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
     use HasFactory;
     protected $table = 'supports';

        protected $fillable = [
        'id',
        'support_type',
        'support_description',
        'support_oder',
        'remarks',
        'status',
        'created_by',
    ];
}
