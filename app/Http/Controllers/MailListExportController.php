<?php

namespace App\Http\Controllers;

use App\Contracts\MailListExport;

class MailListExportController extends Controller
{
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
