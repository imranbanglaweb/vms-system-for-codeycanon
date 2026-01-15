<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
       protected $table = 'rooms';

        protected $fillable = [
        'id',
        'room_name',
        'room_type',
        'room_discription',
        'room_available',
        'room_guests',
        'amount',
        'children',
        'adult',
        'room_main_image',
        'min_booking',
        'room_bed_size',
        'room_size_sft',
        'room_reviews',
        'room_offer',
        'room_booking',
        'room_oder',
        'remarks',
        'status',
        'created_by',
    ];
}
