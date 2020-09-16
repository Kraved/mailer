<?php


namespace App\Contracts\Maillist\Export;

/**
 * Интерфейс MailListExport
 * @package App\Contracts
 */
interface MailListExport
{
    /**
     * Возвращает путь временного файла
     * @return string
     */
    function getExportFilePath() :string;

    /**
     * Возвращает ответ сервера для возможности скачать файл
     * @return mixed
     */
    function getResponse();
}