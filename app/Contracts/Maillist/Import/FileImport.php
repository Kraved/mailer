<?php


namespace App\Contracts\Maillist\Import;


use Illuminate\Http\UploadedFile;

interface FileImport
{

    function setFile(UploadedFile  $site);
    function import();
}