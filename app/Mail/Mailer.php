<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

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
        if (array_key_exists('file', $this->msg)) {
            $filepath = $this->msg['file'];
            $filename = str_replace('/tmp/', '', $filepath);
            return $this->view('mailer.mail')
                ->with(['msg' => $this->msg['text']])
                ->subject($this->msg['subject'])
                ->attach($filepath, [
                    'as' => $filename,
                    'mime' => File::mimeType($filepath),
                ]);
        }else{
            return $this->view('mailer.mail')
                ->with(['msg' => $this->msg['text']])
                ->subject($this->msg['subject']);
        }
    }

}
