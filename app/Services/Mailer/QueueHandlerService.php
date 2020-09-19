<?php


namespace App\Services\Mailer;


use App\Contracts\Mailer\MailHandler;
use App\Jobs\MailerJob;
use Illuminate\Support\Collection;

/**
 * Класс QueueHandlerService обработчик рассылки через очереди
 * @package App\Services\Mailer
 */
class QueueHandlerService extends HandlerService implements MailHandler
{

    /**
     * Рассылка
     * @param Collection $emails
     * @return bool
     */
    public function send(Collection $emails): bool
    {
        $emails->each(function ($mail){
            dispatch(new MailerJob($mail, $this->msg))->onQueue('sync');
            info("Пользователем {$this->user->name} выполнена рассылка на почтовый адрес {$mail}");
        });
        return true;
    }

}