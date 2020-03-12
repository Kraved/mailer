<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailerSendRequest;
use App\Mail\Mailer;
use App\Models\MailList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;
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
        $subject = $request->subject;
        $message = $request->message;
        $file = $request->file('file');
        foreach ($mails as $mail) {
            $email = str_replace("\n", '', $mail->email);
            Mail::to($email)
                ->send(new Mailer($subject, $message, $file));
            $result[] = "Сообщение на почту {$email} успешно доставлено";
        }
        return redirect(route('mailer.mailer.index'))
            ->with(['success' => $result]);
    }
}
