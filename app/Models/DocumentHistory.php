<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentHistory extends Model
{
    protected $fillable = [
        'document_id',
        'action',
        'details',
        'performed_by',
        'action_date'
    ];

    protected $casts = [
        'action_date' => 'datetime'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
} 