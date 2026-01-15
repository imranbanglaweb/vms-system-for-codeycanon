<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'project_id',
        'land_id',
        'document_id',
        'document_taker',
        'witness_name',
        'withdrawal_reason',
        'vault_number',
        'vault_location',
        'proposed_return_date',
        'actual_return_date',
        'returned_documents',
        'returner_name',
        'submitter_name',
        'submitter_signature',
        'return_witness',
        'status',
        'approval_status',
        'document_scan',
        'created_by'
    ];

    protected $casts = [
        'date' => 'datetime',
        'proposed_return_date' => 'datetime',
        'actual_return_date' => 'datetime',
        'approved_at' => 'datetime'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function land()
    {
        return $this->belongsTo(Land::class, 'land_id');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getWithdrawalReasonAttribute($value)
    {
        return Purifier::clean($value);
    }

    public function histories()
    {
        return $this->hasMany(DocumentHistory::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isPending()
    {
        return $this->approval_status === 'pending';
    }

    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    public function isRejected()
    {
        return $this->approval_status === 'rejected';
    }

    public function getDocumentScanUrlAttribute()
    {
        if ($this->document_scan) {
            return Storage::url('documents/' . $this->document_scan);
        }
        return null;
    }
} 