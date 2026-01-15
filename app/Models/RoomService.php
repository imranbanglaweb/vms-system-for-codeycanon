<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomService extends Model
{
    use HasFactory;

    protected $table = 'room_services';

        protected $fillable = [
        'id',
        'room_id',
        'service_name',
        'service_type',
        'service_discription',
        'status',
        'created_by',
    ];

}
