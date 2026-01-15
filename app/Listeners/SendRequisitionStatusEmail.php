<?php

namespace App\Listeners;

use App\Events\RequisitionStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRequisitionStatusEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RequisitionStatusChanged  $event
     * @return void
     */
    public function handle(RequisitionStatusChanged $event)
    {
        //
    }
}
