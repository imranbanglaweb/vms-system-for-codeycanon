<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    
    use HasFactory;

    protected $table = 'room_images';

        protected $fillable = [
        'id',
        'room_id',
        'room_image',
        'status',
        'created_by',
    ];
}
