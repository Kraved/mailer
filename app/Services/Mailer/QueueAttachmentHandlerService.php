<?php


namespace App\Services\Mailer;


use App\Contracts\Mailer\MailHandler;
use App\Jobs\MailerAttachmentJob;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Класс QueueAttachmentHandlerService обработчик рассылки с вложением через очереди
 * @package App\Services\Mailer
 */
class QueueAttachmentHandlerService extends HandlerService implements MailHandler
{
    /**
     * QueueAttachmentHandlerService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->attachment = $this->setAttachment();
    }

    /**
     * Устанавливает рассылку в очередь
     * @param Collection $emails
     * @return bool
     */
    public function send(Collection $emails): bool
    {
        $emails->each(function ($mail){
            dispatch(new MailerAttachmentJob($mail, $this->msg , $this->attachment))->onQueue('sync');
            info("Пользователем {$this->user->name} выполнена рассылка на почтовый адрес {$mail}");
        });
        return true;
    }


}