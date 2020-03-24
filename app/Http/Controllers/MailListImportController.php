<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailListImportFileRequest;
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
        $pattern = "/^[A-Za-z0-9][A-Za-z0-9\.\-_]*[A-Za-z0-9]*@([A-Za-z0-9]+([A-Za-z0-9-]*[A-Za-z0-9]+)*\.)+[A-Za-z]*$/";
        $emails = preg_grep($pattern, $links);
        if (empty($emails))
            return back()
                ->withErrors(['msg' => 'На сайте не найдено почтовых адресов!']);
        $this->saveToDB($emails);
        return redirect(route('mailer.maillist.index'))
            ->with(['success' => 'Данные успешно внесены']);
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

}

