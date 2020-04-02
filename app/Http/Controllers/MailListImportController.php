<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailListImportFileRequest;
use App\Models\MailList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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
    public function fileImport()
    {
        return view('mailer.maillist.fileimport');
    }

    /**
     * Отображает форму выбора сайта для импорта с него почтовых адресов
     *
     * @return View
     */
    public function siteImport()
    {
        return view('mailer.maillist.siteimport');
    }

    /**
     * Обработчик импорта данных из файла
     *
     * @param MailListImportFileRequest $request
     * @return RedirectResponse|Redirector
     */
    public function fileImportHandler(MailListImportFileRequest $request)
    {
        $file = $request->file('importfile');
        $mails = file($file);
        $mails = array_map(function ($line) {
            $line =  str_replace(' ', '', $line);
            $line =  str_replace('\n', '', $line);
            return $line;
        }, $mails);
        $checkedMails = $this->checkWithRegExp($mails);
        if (!$checkedMails) {
            return back()
                ->withErrors(['msg' => 'В файле не найдено почтовых адресов!']);
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
     * Обработчик импорта данных с сайта
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function siteImportHandler(Request $request)
    {
        $site = $request->site;
        $links = $this->parser($site);
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
     * Парсит полученный сайт в поиске ссылок.
     * Возвращает список ссылок с убранным "mailto:"
     *
     * @param string $link
     * @return array
     */
    public function parser(string $link):array
    {
        $html = file_get_contents($link);
        $crawler = new Crawler($html);
        $links = $crawler->filter('a')->each(function (Crawler $crawler) {
            $link = str_replace('mailto:', '', $crawler->attr('href'));
            return $link;
        });
        return $links;
    }

    /**
     * Проверка массива данных на соответствие RegEx патерну почтовых адресов
     *
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
     *
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

