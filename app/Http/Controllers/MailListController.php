<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailListImportFileRequest;
use App\Models\MailList;
use App\Repository\MailListRepository;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class MailListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MailListRepository $listRepository
     * @return \Illuminate\Http\Response
     */
    public function index(MailListRepository $listRepository)
    {
        $emails = $listRepository->getAllWithPaginate(30);
        return view('mailer.maillist.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mailer.maillist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param MailList $mailList
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MailList $mailList)
    {
        $data = $request->all();
        $result = $mailList->create($data);
        if ($result) {
            return redirect(route('mailer.maillist.index'))->with(['msg' => 'Почта успешно внесена']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка добавления почты'])
                ->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param MailList $mailList
     * @return \Illuminate\Http\Response
     */
    public function edit($id, MailList $mailList)
    {
        $item = $mailList->findOrFail($id);
        return view('mailer.maillist.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param MailList $mailList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, MailList $mailList)
    {
        $data = $request->all();
        $result = $mailList->findOrFail($id)->update($data);
        if($result){
            return redirect(route('mailer.maillist.index'))
                ->with(['msg' => 'Почта успешно изменена']);
        } else {
            return back()
                ->withErrors(['error1' => 'Ошибка изменения'])
                ->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param MailList $mailList
     * @return void
     * @throws \Exception
     */
    public function destroy($id, MailList $mailList)
    {
        $result = $mailList->findOrFail($id)->delete();
        if($result){
            return redirect(route('mailer.maillist.index'))
                ->with(['msg' => 'Почта успешно удалена']);
        } else {
            return back()
                ->withErrors(['error1' => 'Ошибка удаления']);
        }
    }

    /**
     * Отображает форму импорта файла с почт. адресами
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importFromFile()
    {
        return view('mailer.maillist.fileimport');
    }

    /**
     * Отображает форму выбора сайта для импорта с него почтовых адресов
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importFromSite()
    {
        return view('mailer.maillist.siteimport');
    }


    /**
     * Вносит данные из файла в базу
     *
     * @param MailListImportFileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveFromImportFile(MailListImportFileRequest $request)
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
            ->with(['msg' => 'Данные успешно внесены']);
    }

    /**
     * Парсит сайт в поиске почтовых адресов
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
            ->with(['msg' => 'Данные успешно внесены']);
    }

    /**
     * Сохраняет данные из массива в таблицу
     *
     * @param array $mailsArray
     */
    public function saveToDB(array $mailsArray)
    {
        $model = new MailList();
        foreach ($mailsArray as $email) {
            $model->firstOrCreate(['email' => $email]);
        }
    }

    /**
     * Удаляет все данные из таблицы
     *
     * @param MailList $mailList
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteAll(MailList $mailList)
    {
        $result = $mailList->truncate();
        return redirect(route("mailer.maillist.index"))
            ->with(['msg' => 'Все данные успешно удалены']);
    }
}
