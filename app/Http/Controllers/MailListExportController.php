<?php

namespace App\Http\Controllers;

use App\Contracts\Maillist\Export\MailListExport;

class MailListExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Экспорт списка адресов
     * @param MailListExport $exportService
     * @return mixed
     */
    public function export(MailListExport $exportService)
    {
        return $exportService->getResponse();
    }
}
