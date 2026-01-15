<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // use HasFactory;
       protected $table ='events';

        protected $fillable = [
        'id',
        'event_name',
        'event_content',
        'mobile',
        'email',
        'event_main_image',
        'event_oder',
        'remarks',
        'status',
        'created_by',
    ];
}
