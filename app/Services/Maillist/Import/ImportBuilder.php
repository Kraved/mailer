<?php


namespace App\Services\Maillist\Import;


use App\Contracts\Maillist\Import\FileImport;
use App\Contracts\Maillist\Import\SiteImport;
use Illuminate\Http\Request;

/**
 * Class ImportBuilder Простая Фабрика создает обработки импорта для Maillist
 * @package App\Services\Maillist\Import
 */
class ImportBuilder
{
    private $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function build()
    {
        if ($this->request->hasFile('importfile')) {
            return app(FileImport::class, [$this->request]);

        } elseif ($this->request->has('site')) {
            return app(SiteImport::class, [$this->request]);
        }
    }

}