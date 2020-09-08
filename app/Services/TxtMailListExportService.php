<?php

namespace App\Services;

use App\Contracts\MailListExport;
use App\Repository\MailListRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use \Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class TxtMailListExportService
 * @package App\Services
 */
class TxtMailListExportService implements MailListExport
{

    /**
     * Возвращает путь файла с экспортированными данными,
     * либо false, если данных нет.
     * @return bool|string
     */
    public function getExportFilePath(): string
    {
        $repository = app(MailListRepository::class);
        /** @var Collection $data */
        $data = $repository->getMailToExport();
        if ($data->isEmpty()) {
            return false;
        }
        $dir = 'storage/tmp';
        $tmpFilePath = tempnam($dir, 'mailer_');
        if (!$tmpFilePath)
            throw  new FileNotFoundException($tmpFilePath);
        foreach ($data as $line) {
            file_put_contents($tmpFilePath, $line . "\n", FILE_APPEND);
        }
        return $tmpFilePath;
    }


    /**
     * Возвращает ответ для скачивания файла, или сообщение об отсутствии данных
     * @return RedirectResponse|BinaryFileResponse
     */
    function getResponse()
    {
        $filePath = $this->getExportFilePath();
        if ($filePath) {
            return response()->download($filePath, 'export.txt')
                ->deleteFileAfterSend(true);
        } else {
            return back()
                ->withErrors(['error' => 'Нет данных для экспорта']);
        }
    }
}
