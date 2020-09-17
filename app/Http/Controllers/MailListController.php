<?php

namespace App\Http\Controllers;

use App\Models\MailList;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;


/**
 * Контроллер работы со списком почтовых адресов
 * @package App\Http\Controllers
 */
class MailListController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }


    /**
     * Display a listing of the resource.
     *
     * @param MailList $mailList
     * @return View
     */
    public function index(MailList $mailList)
    {

        $emails = $mailList->paginate(30);
        return view('mailer.maillist.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('mailer.maillist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param MailList $mailList
     * @return RedirectResponse
     */
    public function store(Request $request, MailList $mailList)
    {
        $data = $request->all();
        $result = $mailList->create($data);
        if ($result) {
            return redirect(route('mailer.maillist.index'))
                ->with(['success' => 'Почта успешно внесена']);
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
     * @return View
     */
    public function edit($id, MailList $mailList)
    {
        $item = $mailList->findOrFail($id);
        return view('mailer.maillist.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @param MailList $mailList
     * @return RedirectResponse
     */
    public function update(Request $request, $id, MailList $mailList)
    {
        $data = $request->all();
        $result = $mailList->findOrFail($id)->update($data);
        if($result){
            return redirect(route('mailer.maillist.index'))
                ->with(['success' => 'Почта успешно изменена']);
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
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy($id, MailList $mailList)
    {
        $result = $mailList->findOrFail($id)->delete();
        if($result){
            return redirect(route('mailer.maillist.index'))
                ->with(['success' => 'Почта успешно удалена']);
        } else {
            return back()
                ->withErrors(['error1' => 'Ошибка удаления']);
        }
    }


    /**
     * Удаляет все данные из таблицы
     *
     *
     * @param MailList $mailList
     * @return Redirector
     */
    public function deleteAll(MailList $mailList)
    {

        $mailList->truncate();
        return redirect(route("mailer.maillist.index"))
            ->with(['success' => 'Все данные успешно удалены']);
    }
}
