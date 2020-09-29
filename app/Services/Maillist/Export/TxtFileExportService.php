<?php

namespace App\Services\Maillist\Export;

use App\Contracts\Maillist\Export\MailListExport;
use App\Models\MailList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use \Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class TxtMailListExportService
 * @package App\Services
 */
class TxtFileExportService implements MailListExport
{

    /**
     * Возвращает путь файла с экспортированными данными,
     * либо false, если данных нет.
     * @return bool|string
     */
    public function getExportFilePath(): string
    {
        $dir = 'storage/tmp';
        $tmpFilePath = tempnam($dir, 'mailer_');
        if (!$tmpFilePath)
            throw new FileNotFoundException($tmpFilePath);

        return $tmpFilePath;
    }

    /**
     * Записывает данные в экспортный файл
     * Возвращает путь экспортного файла, либо фолс, если нет данных
     * @param string $filePath
     * @return string|bool
     */
    public function writeData(string $filePath)
    {
        $model = app(MailList::class);
        $allRecords = $model->all();
        /** @var Collection $allRecords */
        $data = $allRecords->map(function ($key) {
            return $key->email;
        });
        if ($data->isEmpty()) {
            return false;
        }
        foreach ($data as $line) {
            file_put_contents($filePath, $line . "\n", FILE_APPEND);
        }
        return $filePath;
    }

    /**
     * Возвращает ответ для скачивания файла, или сообщение об отсутствии данных
     * @return RedirectResponse|BinaryFileResponse
     */
    public function getResponse()
    {
        $filePath = $this->getExportFilePath();
        $result = $this->writeData($filePath);
        if ($result) {
            return response()->download($filePath, 'export.txt')
                ->deleteFileAfterSend(true);
        } else {
            return back()
                ->withErrors(['error' => 'Нет данных для экспорта']);
        }
    }
}
