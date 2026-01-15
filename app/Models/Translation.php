<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Translation extends Model
{
    protected $fillable = ['group', 'key', 'text'];

    protected $casts = [
        'values' => 'array', // automatically decode/encode JSON
    ];
    
    public function values()
    {
        return $this->hasMany(TranslationValue::class);
    }
    
    public function getTranslation($languageCode)
    {
        return $this->values()
            ->where('language_code', $languageCode)
            ->first()
            ->value ?? $this->text;
    }
     public function getValue(string $locale): ?string
    {
        $value = $this->values->firstWhere('language_code', $locale)?->value;

        // Fallback to default text if value missing
        return $value ?: $this->text;
    }
}