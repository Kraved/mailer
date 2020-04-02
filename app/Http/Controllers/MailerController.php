<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailerSendRequest;
use App\Jobs\MailerJob;
use App\Models\MailList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

/**
 * Контроллер рассылки
 * @package App\Http\Controllers
 */
class MailerController extends Controller
{


    public function __construct()
    {
        $this->middleware('verified');
    }


    /**
     * Отображение формы рассылаемого сообщения
     *
     * @return View
     */
    public function index()
    {
        return view('mailer.mailer.index');
    }


    /**
     * Отправка сообщения
     *
     * @param MailerSendRequest $request
     * @return RedirectResponse|Redirector
     */
    public function send(MailerSendRequest $request)
    {
        $result = $this->sendHandler($request);
        return redirect(route('mailer.mailer.index'))
            ->with(['result' => $result]);
    }

    /** Обработчик отправки сообщения
     *
     * @param MailerSendRequest $request
     * @return array
     */
    public function sendHandler(MailerSendRequest $request)
    {
        $tmpdir = '/tmp';
        $mails = MailList::all();
        $message = (array)$request->all();
        if ($request->hasFile('file')) {
            $file = $request->file('file')->move($tmpdir, $request->file('file')->getClientOriginalName());
            $filePath = $file->getRealPath();
            $message['file'] = $filePath;
        }
        $result = [];
        foreach ($mails as $item) {
            $this->dispatch(new MailerJob($item->email, $message));
            $result[] = "Сообщение на почту {$item->email} поставлено в очередь";
        }
        return $result;
    }
}
