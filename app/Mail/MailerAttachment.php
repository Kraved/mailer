<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class MailerAttachment extends Mailable
{
    use Queueable, SerializesModels;

    private $msg;
    private $attachment;

    /**
     * Create a new message instance.
     *
     * @param array $msg
     * @param string $attachment
     */
    public function __construct(array $msg, string $attachment)
    {
        $this->msg = $msg;
        $this->attachment = $attachment;
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
            ->subject($this->msg['subject'])
            ->attach($this->attachment, [
                'as' => File::name($this->attachment),
                'mime' => File::mimeType($this->attachment),
            ]);
    }
}
