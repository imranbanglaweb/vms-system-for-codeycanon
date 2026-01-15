<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dinningimage extends Model
{
    use HasFactory;

      protected $table = 'dinningimages';

        protected $fillable = [
        'id',
        'dinning_name',
        'dinning_content',
        'dinning_category',
        'dinning_main_image',
        'dinning_oder',
        'status',
        'created_by',
    ];
}
