<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    // use HasFactory;
      // use HasFactory;

     protected $table = 'pages';
        protected $fillable = [
        'id',
        'page_name',
        'page_description',
        'page_link',
        'page_slug',
        'page_image',
        'page_oder',
        'status',
        'created_by',
    ];

}
