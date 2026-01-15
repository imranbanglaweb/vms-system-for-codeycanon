<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
     // use HasFactory;

     protected $table = 'galleries';

        protected $fillable = [
        'id',
        'gallery_name',
        'gallery_description',
        'category_id',
        'gallery_image',
        'gallery_oder',
        'status',
        'created_by',
    ];
}
