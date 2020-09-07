<?php


namespace App\Contracts;

/**
 * Интерфейс MailListExport
 * @package App\Contracts
 */
interface MailListExport
{
    function getExportFilePath() :string;

    function getResponse();
}