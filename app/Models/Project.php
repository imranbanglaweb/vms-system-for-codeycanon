<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'project_name',
        'project_description',
        'starting_date ',
        'ending_date ',
        'status'
    ];

    protected $casts = [
        'starting_date' => 'datetime',
        'ending_date' => 'datetime'
    ];
}
