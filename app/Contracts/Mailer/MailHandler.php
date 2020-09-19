<?php


namespace App\Contracts\Mailer;


use Illuminate\Support\Collection;

/**
 * Обработчик рассылки
 * Interface MailHandler
 * @package App\Contracts\Mailer
 */
interface MailHandler
{
    /**
     * Рассылка
     * @param Collection $emails
     * @return bool
     */
    public function send(Collection $emails): bool;
}