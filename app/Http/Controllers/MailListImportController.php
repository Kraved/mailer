<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailListImportFileRequest;
use App\Models\MailList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Контроллер импорта списков почтовых адресов
 *
 * Class MailListImportController
 * @package App\Http\Controllers
 */
class MailListImportController extends Controller
{

    /**
     * Отображает форму импорта файла с почт. адресами
     *
     * @return View
     */
    public function importFromFile()
    {
        return view('mailer.maillist.fileimport');
    }

    /**
     * Отображает форму выбора сайта для импорта с него почтовых адресов
     *
     * @return View
     */
    public function importFromSite()
    {
        return view('mailer.maillist.siteimport');
    }

    public function importFromFileHandler(MailListImportFileRequest $request)
    {
        $file = $request->file('importfile');
        $mailsArray = file($file);
        $mailsArray = array_map(function ($line) {
            return str_replace(' ', '', $line);
        }, $mailsArray);
        $pattern = "/^[A-Za-z0-9][A-Za-z0-9\.\-_]*[A-Za-z0-9]*@([A-Za-z0-9]+([A-Za-z0-9-]*[A-Za-z0-9]+)*\.)+[A-Za-z]*$/";
        $data = preg_grep($pattern, $mailsArray);
        if (empty($data))
            return back()
                ->withErrors(['msg' => 'В файле не найдено почтовых адресов!']);
        $this->saveToDB($data);
        return redirect(route('mailer.maillist.index'))
            ->with(['success' => 'Данные успешно внесены']);
    }


    /**
     * Парсит сайт в поиске почтовых адресов
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveFromImportSite(Request $request)
    {
        $site = $request->site;
        $html = file_get_contents($site);
        $crawler = new Crawler($html);
        $links = $crawler->filter('a')->each(function (Crawler $crawler) {
            $emailLink = str_replace('mailto:', '',$crawler->attr('href'));
            return $emailLink;
        });
        if (empty($links)){
            return back()
                ->withErrors(['msg' => 'На сайте не найдено почтовых адресов!']);
        }
        $checkedMails = $this->checkWithRegExp($links);
        if (!$checkedMails) {
            return back()
                ->withErrors(['msg' => 'На сайте не найдено почтовых адресов!']);
        }
        $result = $this->saveCheckedData($checkedMails);
        if (!empty($result)) {
            return redirect(route('mailer.mailer.index'))
                ->with(['result' => $result]);
        } else {
            return back(0)
                ->withErrors(['msg' => 'Ошибка сохранения в базу']);
        }

    }

    /**
     * Проверка массива данных на соответствие RegEx патерну почтовых адресов
     * @param array $data
     * @return array|bool
     */
    public function checkWithRegExp(array $data)
    {
        $pattern = "/^[A-Za-z0-9][A-Za-z0-9\.\-_]*[A-Za-z0-9]*@([A-Za-z0-9]+([A-Za-z0-9-]*[A-Za-z0-9]+)*\.)+[A-Za-z]*$/";
        $mails = preg_grep($pattern, $data);
        if (empty($mails)) {
            return false;
        }else{
            return $mails;
        }
    }

    /**
     * Принимает список проверенных почтовых адресов, и сохраняет их в таблицу почт. адресов.
     * Возвращает результат сохранения.
     * Если почта присутствует в таблице, возвращает сообщение.
     * @param array $mails
     * @return array
     */
    public function saveCheckedData(array $mails):array
    {
        $model = new MailList();
        $backData = [];
        foreach ($mails as $mail) {
            $result = $model->customFindOrNew(['email' => $mail]);
            $result ? $backData[] =  "Почта {$mail} успешно добавлена": $backData[] = "Почта {$mail} присутствует в списке";
        }
        return $backData;
    }

}
