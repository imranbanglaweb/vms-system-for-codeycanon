<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dinning extends Model
{
    use HasFactory;
      protected $table = 'dinnings';

        protected $fillable = [
        'id',
        'dinning_name',
        'dinning_content',
        'dinning_category',
        'mobile',
        'email',
        'dinning_main_image',
        'dinning_oder',
        'status',
        'created_by',
    ];
}
