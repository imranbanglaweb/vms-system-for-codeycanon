<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class tasktitle extends Model
{
    use HasFactory;
       protected $table = 'tasktitles';
        protected $fillable = [
        'id',
        'category_id',
        'task_title',
        'remarks',
        'created_by',
        'status',
        'created_by',
    ];

          public function categoryNameByTitle(){

        return $this->belongsTo(Category::class,'category_id');
    }
}
