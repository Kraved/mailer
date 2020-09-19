<?php


namespace App\Contracts\Mailer;

/**
 * Рассылка сообщений
 * @package App\Contracts\Mailer
 */
interface Mailer
{
    /**
     * Установка стратегии рассылки
     * @return mixed
     */
    public function setMailHandler();

    /**
     * Рассылка
     * @return bool
     */
    public function send(): bool;
}