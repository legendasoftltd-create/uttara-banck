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
    public $view;

    public function __construct(Complaint $complaint, $subject, $view = 'mail.complaint')
    {
        $this->complaint = $complaint;
        $this->subject = $subject;
        $this->view = $view;
    }

    public function build()
    {
        return $this->from(get_static_option('site_global_email'), get_static_option('site_'.get_default_language().'_title'))
            ->subject($this->subject)
            ->view($this->view);
    }
}
