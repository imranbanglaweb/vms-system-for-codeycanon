<?php

namespace App\Mail;

use App\Models\Department;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DepartmentHeadAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $department;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Department Head Assignment - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'admin.dashboard.emails.department_head_assigned',
            with: [
                'department' => $this->department,
                'headName' => $this->department->head_name,
                'headEmail' => $this->department->head_email,
                'departmentName' => $this->department->department_name,
                'companyName' => config('app.name'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
