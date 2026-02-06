<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class DepartmentApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $requisition;

    public function __construct($requisition)
    {
        $this->requisition = $requisition;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
        ->title('Department Approved: ' . $this->requisition->requisition_number)
        ->body('A requisition has been approved by the department. Click to view details.')
        ->icon('https://tms.nextdigihome.com/public/admin_resource/assets/images/icons.png')
        ->data([
            'url' => route('requisitions.show', $this->requisition->id)
        ])
        ->action('View Requisition', route('requisitions.show', $this->requisition->id));
    }

    public function toDatabase($notifiable)
    {
        $approvedById = $this->requisition->department_approved_by;
        $approvedByName = 'Department Head';
        
        if ($approvedById) {
            $approvedBy = \App\Models\User::find($approvedById);
            if ($approvedBy) {
                $approvedByName = $approvedBy->name;
            }
        }
        
        return [
            'title' => "Department Approved: {$this->requisition->requisition_number}",
            'message' => "Requisition has been approved by {$approvedByName}.",
            'url' => route('requisitions.show', $this->requisition->id)
        ];
    }
}
