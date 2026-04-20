<?php

namespace App\Observers;

use App\Jobs\SendRequisitionCreatedEmailJob;
use App\Models\Requisition;
use App\Models\User;
use App\Notifications\RequisitionCreatedNotification;
use App\Services\EmailService;

class RequisitionObserver
{
    /**
     * @var EmailService
     */
    protected $emailService;

    /**
     * Create a new observer instance.
     *
     * @return void
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle the Requisition "created" event.
     *
     * @return void
     */
    public function created(Requisition $requisition)
    {
        // Send email notification to department head via queued job
        SendRequisitionCreatedEmailJob::dispatch($requisition);

        // Also send push notifications to admins (existing behavior)
        // Optimized: use withCount() for efficient count check
        $users = User::where('role', 'admin')
            ->withCount('pushSubscriptions')
            ->having('push_subscriptions_count', '>', 0)
            ->get();

        foreach ($users as $user) {
            $user->notify(
                new RequisitionCreatedNotification($requisition)
            );
        }
    }

    /**
     * Handle the Requisition "updated" event.
     *
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
     * @return void
     */
    public function deleted(Requisition $requisition)
    {
        //
    }

    /**
     * Handle the Requisition "restored" event.
     *
     * @return void
     */
    public function restored(Requisition $requisition)
    {
        //
    }
}
