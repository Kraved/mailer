<?php


namespace App\Contracts\Maillist\Import;


interface SiteImport
{
    function setSite(string $site);
    function import();
}