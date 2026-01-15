<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TranslatableModel extends Model
{
    protected $translatable = [];
    
    // Auto translate attributes
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        
        // Check if attribute is translatable
        if (in_array($key, $this->translatable) && $value) {
            $locale = session('locale', 'en');
            
            if ($locale !== 'en') {
                $translation = $this->translations()
                    ->where('language_code', $locale)
                    ->where('field_name', $key)
                    ->first();
                    
                if ($translation) {
                    return $translation->value;
                }
            }
        }
        
        return $value;
    }
    
    public function translations()
    {
        return $this->hasMany(ModelTranslation::class, 'model_id')
            ->where('model_type', get_class($this));
    }
}

// ModelTranslation table
class ModelTranslation extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'language_code',
        'field_name',
        'value'
    ];
}

// Example Usage:
class Product extends TranslatableModel
{
    protected $translatable = ['name', 'description', 'specifications'];
    
    protected $fillable = ['name', 'description', 'price', 'specifications'];
}