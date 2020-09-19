<?php


namespace App\Services\Mailer;


use App\Contracts\Mailer\MailHandler;
use App\Mail\Mailer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

/**
 * Класс SimpleHandlerService простой обработчик рассылки
 * @package App\Services\Mailer
 */
class SimpleHandlerService extends HandlerService implements MailHandler
{

    /**
     * Рассылка
     * @param Collection $emails
     * @return bool
     */
    public function send(Collection $emails): bool
    {
        $emails->each(function ($mail){
            Mail::to($mail)->send(new Mailer($this->msg));
            info("Пользователем {$this->user->name} выполнена рассылка на почтовый адрес {$mail}");
        });
        return true;
    }
}