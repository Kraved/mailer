<?php

namespace App\Http\Controllers;

use App\Repository\MailListRepository;

class MailListExportController extends Controller
{
    public function export(MailListRepository $repository)
    {
        $data = $repository->getMailToExport();
        $tmpFile = tempnam("/tmp","");
        foreach ($data as $line)
            file_put_contents($tmpFile, $line , FILE_APPEND);
        return response()->download($tmpFile, 'export.txt');
    }
}
