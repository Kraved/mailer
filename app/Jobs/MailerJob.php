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
    /**
     * @var string
     */
    private $email;
    /**
     * @var array
     */
    private $message;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param array $message
     */
    public function __construct(string $email, array $message)
    {
        $this->email = $email;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new Mailer($this->message));
    }
}
