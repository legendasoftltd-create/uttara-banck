<?php

namespace App\Mail;

use App\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintMail extends Mailable
{
    use Queueable, SerializesModels;
    public $complaint;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Complaint $complaint, $subject)
    {
        $this->complaint = $complaint;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(get_static_option('site_global_email'), get_static_option('site_'.get_default_language().'_title'))
            ->subject($this->subject)
            ->view('mail.complaint');
    }
}
