<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;


     protected $table = 'settings';

        protected $fillable = [
        'id',
        'site_title',
        'site_description',
        'admin_title',
        'admin_description',
        'site_logo',
        'site_copyright_text',
        'admin_logo',
        'status',
        'created_by',
        'default_language',
        'available_languages',
        'auto_translate',
        'translation_cache_duration',
    ];
}
