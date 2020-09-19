<?php

namespace App\Http\Controllers;

use App\Contracts\Mailer\Mailer;
use App\Http\Requests\Mailer\SendRequest;
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


    public function send(SendRequest $request)
    {
        /** @var Mailer $mailer */
        $mailer = app(Mailer::class, [$request]);
        $result = $mailer->send();
        if ($result) {
            return redirect(route('mailer.mailer.index'))
                ->with(['success' => 'Сообщение поставлено в очередь на отправку']);
        } else {
            return back()
                ->withErrors(['error' => 'Ошибка отправки сообщения!', 'error1' => 'Список рассылки пуст!'])
                ->withInput();

        }
    }

}
