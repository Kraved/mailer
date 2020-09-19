<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;

    private $msg;

    /**
     * Mailer constructor.
     * @param array $msg
     */
    public function __construct(array $msg)
    {
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mailer.mail')
            ->with(['msg' => $this->msg['text']])
            ->subject($this->msg['subject']);
    }

}
