<?php


namespace App\Contracts\Maillist\Import;


use Illuminate\Http\UploadedFile;

/**
 * Импорт почтовых адресов из файла
 * Interface FileImport
 * @package App\Contracts\Maillist\Import
 */
interface FileImport
{

    /**
     * Установка файла для импорта
     * @param UploadedFile $site
     * @return mixed
     */
    function setFile(UploadedFile  $site);

    /**
     * Импорт
     * @return mixed
     */
    function import();
}