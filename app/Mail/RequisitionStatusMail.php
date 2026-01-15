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

    public function __construct(Requisition $requisition, $oldStatus, $newStatus, $remarks = null)
    {
        $this->requisition = $requisition;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->remarks = $remarks;
    }

    public function build()
    {
        return $this->subject("Requisition #{$this->requisition->id} status changed")
                    ->markdown('emails.requisition.status')
                    ->with([
                        'requisition' => $this->requisition,
                        'oldStatus' => $this->oldStatus,
                        'newStatus' => $this->newStatus,
                        'remarks' => $this->remarks,
                    ]);
    }
}