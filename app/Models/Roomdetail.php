<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roomdetail extends Model
{
       use HasFactory;
       protected $table = 'roomdetails';

        protected $fillable = [
        'id',
        'room_id',
        'service_id',
        'roomdetails_oder',
        'remarks',
        'status',
        'created_by',
    ];
}
