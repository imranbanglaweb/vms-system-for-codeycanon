<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * GenericMailable - A reusable mailable for sending templated emails
 * 
 * This mailable is used by EmailService to send emails with dynamic content
 */
class GenericMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The email subject
     *
     * @var string
     */
    public $subject;

    /**
     * The email body content
     *
     * @var string
     */
    public $body;

    /**
     * Create a new message instance
     *
     * @param string $subject
     * @param string $body
     */
    public function __construct(string $subject, string $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Build the message
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.generic')
                    ->with('body', $this->body);
    }
}
