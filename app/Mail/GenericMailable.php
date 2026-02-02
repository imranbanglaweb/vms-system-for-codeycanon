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
     * Optional recipient email
     *
     * @var string|null
     */
    public $email;

    /**
     * Optional action button URL
     *
     * @var string|null
     */
    public $action_url;

    /**
     * Optional action button text
     *
     * @var string|null
     */
    public $action_text;

    /**
     * Create a new message instance
     *
     * @param string $subject
     * @param string $body
     * @param string|null $email
     * @param string|null $action_url
     * @param string|null $action_text
     */
    public function __construct(
        string $subject, 
        string $body,
        ?string $email = null,
        ?string $action_url = null,
        ?string $action_text = null
    ) {
        $this->subject = $subject;
        $this->body = $body;
        $this->email = $email;
        $this->action_url = $action_url;
        $this->action_text = $action_text;
    }

    /**
     * Build the message
     *
     * @return $this
     */
    public function build()
    {
        // Check if body is already a complete email template (starts with table tag)
        $isCompleteTemplate = (
            stripos(trim($this->body), '<table') === 0 ||
            stripos($this->body, '<!DOCTYPE') !== false || 
            stripos($this->body, '<html') !== false ||
            stripos($this->body, '<head') !== false ||
            stripos($this->body, '<body') !== false
        );

        if ($isCompleteTemplate) {
            // Send the body directly as complete HTML email
            return $this->subject($this->subject)
                        ->html($this->body);
        } else {
            // Wrap in the premium email template
            return $this->subject($this->subject)
                        ->view('emails.generic')
                        ->with([
                            'body' => $this->body,
                            'email' => $this->email,
                            'action_url' => $this->action_url,
                            'action_text' => $this->action_text,
                        ]);
        }
    }
}
