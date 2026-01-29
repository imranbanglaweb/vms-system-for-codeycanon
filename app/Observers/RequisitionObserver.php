<?php

namespace App\Observers;

use App\Models\Requisition;
use App\Models\User;
use App\Services\EmailService;
use App\Notifications\RequisitionCreatedNotification;

class RequisitionObserver
{
    /**
     * @var EmailService
     */
    protected $emailService;

    /**
     * Create a new observer instance.
     *
     * @param EmailService $emailService
     * @return void
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle the Requisition "created" event.
     *
     * @param Requisition $requisition
     * @return void
     */
    public function created(Requisition $requisition)
    {
        // Send email notification to department head
        $this->emailService->sendRequisitionCreated($requisition);

        // Also send push notifications to admins (existing behavior)
        $users = User::where('role', 'admin')->get();

        foreach ($users as $user) {
            if ($user->pushSubscriptions()->count()) {
                $user->notify(
                    new RequisitionCreatedNotification($requisition)
                );
            }
        }
    }

    /**
     * Handle the Requisition "updated" event.
     *
     * @param Requisition $requisition
     * @return void
     */
    public function updated(Requisition $requisition)
    {
        // Check if status has changed
        if ($requisition->isDirty('status')) {
            $oldStatus = $requisition->getOriginal('status');
            $newStatus = $requisition->status;

            // Dispatch event for email notifications via listener
            event(new \App\Events\RequisitionStatusChanged($requisition, $oldStatus, $newStatus));
        }
    }

    /**
     * Handle the Requisition "deleted" event.
     *
     * @param Requisition $requisition
     * @return void
     */
    public function deleted(Requisition $requisition)
    {
        //
    }

    /**
     * Handle the Requisition "restored" event.
     *
     * @param Requisition $requisition
     * @return void
     */
    public function restored(Requisition $requisition)
    {
        //
    }
}
