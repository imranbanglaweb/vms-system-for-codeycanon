<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

      protected $table = 'contacts';

        protected $fillable = [
        'id',
        'contact_name',
        'contact_mobile',
        'contact_email',
        'contact_content',
        'ip_address',
        'mac_address',
        'event_oder',
        'remarks',
        'status',
        'created_by',
    ];

}
