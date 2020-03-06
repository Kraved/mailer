<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailerSendRequest;
use App\Mail\Mailer;
use App\Models\MailList;
use Illuminate\Support\Facades\Mail;

class MailerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('mailer.mailer.index');
    }

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
