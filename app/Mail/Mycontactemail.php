<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mycontactemail extends Mailable
{
    use Queueable, SerializesModels;

     public $task_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($task_details)
    {
        $this->task_details = $task_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
          return $this->subject('Mail from Ticketing System')
                    ->view('admin.dashboard.email.contactlistemail');
    }
}
