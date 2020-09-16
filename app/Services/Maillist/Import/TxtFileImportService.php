<?php


namespace App\Services\Maillist\Import;


use App\Contracts\Maillist\Import\FileImport;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class TxtFileImportService extends BaseImport implements FileImport
{

    /**
     * @var UploadedFile $file
     */
    private $file;


    public function __construct(Request $request)
    {
        $this->setFile($request->file('importfile'));
    }

    /**
     * Задает файл для дальнейшей обработки
     * @param UploadedFile $file
     */
    function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * Обаботчик импорта
     * @return bool
     */
    function import()
    {
        $mails = file($this->file->path());
        $mails = $this->txtFileParser($mails);
        $checkedMails = $this->checkWithRegExp($mails);
        if (!$checkedMails) {
            $msg = "В файле не обнаружено email адресов";
            info($msg);
            return false;
        }
        $result = $this->saveCheckedData($checkedMails);
        if (! $result) {
            $msg = "Ошибка сохранения в базу";
            info($msg);
            return false;
        }
        return true;
    }

    /**
     * Парсер тхт файла
     * @param array $mails
     * @return array
     */
    function txtFileParser(array $mails)
    {
        return $mails = array_map(function ($line) {
            $line =  str_replace(' ', '', $line);
            $line =  str_replace("\n", '', $line);
            return $line;
        }, $mails);
    }
}