<?php


namespace App\Services\Mailer;


use App\Contracts\Mailer\MailHandler;
use App\Mail\MailerAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

/**
 * Класс SimpleAttachmentHandleService обработчик рассылки с вложением
 * @package App\Services\Mailer
 */
class SimpleAttachmentHandleService extends HandlerService implements MailHandler
{
    /**
     * SimpleAttachmentHandleService constructor.
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
            Mail::to($mail)->send(new MailerAttachment($this->msg, $this->attachment));
            info("Пользователем {$this->user->name} выполнена рассылка на почтовый адрес {$mail}");
        });
        return true;
    }
}