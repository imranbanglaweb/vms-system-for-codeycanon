<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

     protected $table = 'offers';

        protected $fillable = [
        'id',
        'offer_title',
        'offer_caption',
        'offer_content',
        'offer_time',
        'offer_image',
        'offer_oder',
        'status',
        'created_by',
    ];
}
