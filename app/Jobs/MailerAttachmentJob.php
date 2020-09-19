<?php

namespace App\Jobs;

use App\Mail\MailerAttachment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailerAttachmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mail;
    private $msg;
    private $attachment;


    /**
     * Create a new job instance.
     *
     * @param $mail
     * @param $msg
     * @param $attachment
     */
    public function __construct($mail, $msg, $attachment)
    {
        $this->mail = $mail;
        $this->msg = $msg;
        $this->attachment = $attachment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->mail)->send(new MailerAttachment($this->msg, $this->attachment));
    }
}
