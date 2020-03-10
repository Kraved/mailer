<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AfterRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Имя зарегистрированного пользователя
     * @var int $name
     */
    private $name;

    /**
     * Create a new message instance.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg = "Внимание! В Mailer зарегистрирован новый пользователь $this->name";
        return $this->view('mailer.mail')
            ->with(["msg" => $msg])
            ->subject('Зарегистрирован новый пользователь');
    }
}
