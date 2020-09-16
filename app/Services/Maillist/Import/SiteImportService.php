<?php


namespace App\Services\Maillist\Import;


use App\Contracts\Maillist\Import\SiteImport;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class SiteImportService extends BaseImport implements SiteImport
{

    /**
     * @var string $site
     */
    private $site;


    public function __construct(Request $request)
    {
        $this->setSite($request->site);
    }

    /**
     * Задает сайт для обработки его парсером
     * @param string $site
     */
    function setSite(string $site)
    {
        $this->site = $site;
    }

    /**
     * Обработчик импорта
     * @return bool
     */
    function import()
    {
        $site = $this->site;
        $links = $this->parser($site);
        if (empty($links)) {
            $msg = "На сайте {$this->site} не найдено ссылок";
            info($msg);
            return false;
        }
        $checkedMails = $this->checkWithRegExp($links);
        if (!$checkedMails) {
            $msg = "На сайте {$this->site} не найдено почтовых адресов!";
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
     * Парсит полученный сайт в поиске ссылок.
     * Возвращает массив ссылок с убранным "mailto:"
     *
     * @param string $link
     * @return array
     */
    public function parser(string $link):array
    {
        $html = file_get_contents($link);
        $crawler = new Crawler($html);
        return $crawler->filter('a')->each(function (Crawler $crawler) {
            $link = str_replace('mailto:', '', $crawler->attr('href'));
            return $link;
        });
    }
}