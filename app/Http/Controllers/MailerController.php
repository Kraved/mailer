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
        $this->middleware('auth');
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
     * @param MailList $mailList
     * @return RedirectResponse|Redirector
     */
    public function send(MailerSendRequest $request, MailList $mailList)
    {
        $mails = $mailList->all();
        $message = (array)$request->all();
        foreach ($mails as $item) {
            $this->dispatch(new MailerJob($item->email,$message));
            $result[] = "Сообщение на почту {$item->email} поставлено в очередь";
        }
        return redirect(route('mailer.mailer.index'))
            ->with(['success' => $result]);
    }
}
