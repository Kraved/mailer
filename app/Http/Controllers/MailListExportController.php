<?php

namespace App\Http\Controllers;

use App\Repository\MailListRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MailListExportController extends Controller
{

    /**
     * Экспорт данных из таблицы
     * Отдает ответ в виде файла
     *
     * @param MailListRepository $repository
     * @return BinaryFileResponse
     */
    public function export(MailListRepository $repository)
    {
        $data = $repository->getMailToExport();
        $tmpFile = tempnam("/tmp","");
        foreach ($data as $line)
            file_put_contents($tmpFile, $line , FILE_APPEND);
        return response()->download($tmpFile, 'export.txt');
    }
}
