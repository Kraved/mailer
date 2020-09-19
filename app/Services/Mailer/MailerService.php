<?php


namespace App\Services\Mailer;

use App\Contracts\Mailer\Mailer;
use App\Contracts\Mailer\MailHandler;
use App\Models\MailList;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class MailerService отвечает за рассылку сообщений по почтовым адресам из MailList
 * @package App\Services\Mailer
 */
class MailerService implements Mailer
{
    private $request;
    /** @var MailHandler обработчик*/
    private $handler;
    /** @var Collection $emails чистый лист почтовых адресов */
    private $emails;


    /**
     * MailerService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->emails = $this->setEmails();
        $this->setMailHandler();
    }

    /**
     * Устанавливает стратегию рассылки
     * @return mixed|void
     */
    public function setMailHandler()
    {
        // Если кол-во почтовых адресов больше 10, будут использованы очереди
        if ($this->emails && $this->emails->count() < 10) {
            if ($this->request->hasFile('file')) {
                $this->handler = app(QueueAttachmentHandlerService::class, [$this->request]);
            } else {
                $this->handler = app(QueueHandlerService::class, [$this->request]);
            }
        } else {
            if ($this->request->hasFile('file')) {
                $this->handler = app(SimpleAttachmentHandleService::class, [$this->request]);
            } else {
                $this->handler = app(SimpleHandlerService::class, [$this->request]);
            }
        }

    }

    /**
     * Возвращает список почтовых адресов
     * @return bool|Collection
     */
    public function setEmails()
    {
        $mailList = MailList::all()->map(function ($key) {
            return $key->email;
        });
        return $mailList->isNotEmpty() ? $mailList : false;
    }

    /**
     * Рассылка
     * @return bool
     */
    public function send(): bool
    {
        // Если список почтовых адресов пуст, вернет ошибку
        if (! $this->emails) {
            return false;
        }
        return $this->handler->send($this->emails);
    }




}