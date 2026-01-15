<?php

namespace App\Observers;

use App\Models\Requisition;
use App\Models\User;
use App\Notifications\RequisitionCreatedNotification;

class RequisitionObserver
{
    public function created(Requisition $requisition)
    {
        // Example: notify all admins
        $users = User::where('role', 'admin')->get();

        foreach ($users as $user) {
            if ($user->pushSubscriptions()->count()) {
                $user->notify(
                    new RequisitionCreatedNotification($requisition)
                );
            }
        }
    }
}
