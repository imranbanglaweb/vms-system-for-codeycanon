<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Requisition;

class RequisitionStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $requisition;
    public $oldStatus;
    public $newStatus;
    public $remarks;
    public $adminTitle;

    public function __construct(Requisition $requisition, $oldStatus, $newStatus, $remarks = null)
    {
        $this->requisition = $requisition;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->remarks = $remarks;
        
        // Get admin title from settings
        $settings = \App\Models\Setting::first();
        $this->adminTitle = $settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০';
    }

    public function build()
    {
        return $this->subject("Requisition #{$this->requisition->id} status changed to {$this->newStatus->name}")
                    ->markdown('emails.requisition.status')
                    ->with([
                        'requisition' => $this->requisition,
                        'oldStatus' => $this->oldStatus,
                        'newStatus' => $this->newStatus,
                        'remarks' => $this->remarks,
                        'adminTitle' => $this->adminTitle,
                    ]);
    }
}
