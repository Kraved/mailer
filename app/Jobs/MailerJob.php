<?php

namespace App\Jobs;

use App\Mail\Mailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mail;
    private $msg;

    /**
     * Create a new job instance.
     *
     * @param string $mail
     * @param array $msg
     */
    public function __construct(string $mail, array $msg)
    {
        $this->mail = $mail;
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->mail)->send(new Mailer($this->msg));
    }
}
