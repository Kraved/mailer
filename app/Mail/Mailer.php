<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;

    private $title = '';
    private $msg = '';
    private $file;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $msg
     * @param UploadedFile $file
     */
    public function __construct(string $subject, string $msg, UploadedFile $file = NULL)
    {
        $this->subject = $subject;
        $this->msg = $msg;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (empty($this->file)) {
            return $this->view('mailer.mail')
                ->with(['msg' => $this->msg])
                ->subject($this->subject);
        }else{
            return $this->view('mailer.mail')
                ->with(['msg' => $this->msg])
                ->subject($this->subject)
                ->attach($this->file->getRealPath(), [
                    'as' => $this->file->getClientOriginalName(),
                    'mime' => $this->file->getMimeType(),
                ]);
        }

    }
}
