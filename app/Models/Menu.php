<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    // use HasFactory;

     protected $table = 'menus';
    // protected $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'menu_name',
        'menu_parent',
        'menu_slug',
        'menu_type',
        'menu_location',
        'menu_icon',
        'menu_order',
        'menu_url',
        'menu_permission',
        'status',
        'created_by',
        'name',
        'url',
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'menu_parent')
                    ->orderBy('menu_order', 'ASC');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'menu_parent');
    }

    // Add a scope to always order by menu_oder
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('menu_order', 'asc');
        });
    }
}
