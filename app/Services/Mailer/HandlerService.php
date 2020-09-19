<?php


namespace App\Services\Mailer;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Класс HandlerService задает основу для обработчиков рассылки
 * @package App\Services\Mailer
 */
abstract class HandlerService
{
    use DispatchesJobs;

    protected $request;
    protected $user;
    protected $attachment;
    protected $msg;

    /**
     * HandlerService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->user = Auth::user();
        $this->msg = $this->setMsg();
    }

    /**
     * Возвращает путь прикрепленного файла
     * @return string
     */
    public function setAttachment(): string
    {
        $file = $this->request->file('file');
        $fileName = $file->getClientOriginalName() . "." . $file->getClientOriginalExtension();
        return Storage::path($file->storePubliclyAs('tmp', $fileName));
    }

    /**
     * Устанавливает заголовок и тело из реквеста
     * @return array
     */
    public function setMsg(): array
    {
        return $this->request->only('subject', 'text');
    }


}