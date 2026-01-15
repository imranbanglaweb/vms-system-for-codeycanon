<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationValue extends Model
{
    protected $fillable = ['translation_id', 'language_code', 'value'];
    
    public function translation()
    {
        return $this->belongsTo(Translation::class);
    }
    
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'code');
    }
}