<?php


namespace App\Contracts\Maillist\Import;


/**
 * Импорт почтовых адресов с сайта
 * Interface SiteImport
 * @package App\Contracts\Maillist\Import
 */
interface SiteImport
{
    /**
     * Установка сайта для импорта
     * @param string $site
     * @return mixed
     */
    function setSite(string $site);

    /**
     * Импорт
     * @return mixed
     */
    function import();
}