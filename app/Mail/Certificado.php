<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Certificado extends Mailable
{
    use Queueable, SerializesModels;

    public $stundent;
    public $subject = 'Certificado';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($stundent)
    {
        $this->student = $stundent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.certificate');
    }
}
