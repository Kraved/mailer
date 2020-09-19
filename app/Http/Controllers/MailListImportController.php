<?php

namespace App\Http\Controllers;

use App\Contracts\Maillist\Import\FileImport;
use App\Contracts\Maillist\Import\SiteImport;
use App\Http\Requests\Maillist\ImportRequest;
use App\Services\Maillist\Import\ImportBuilder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MailListImportController extends Controller
{
    /**
     * Отображает форму импорта из файла, или из сайта
     * @return Factory|View
     */
    public function index()
    {
        return view('mailer.maillist.import');
    }

    /**
     * Сохранение импортируемых данных в БД
     * @param ImportRequest $request
     * @return RedirectResponse
     */
    public function save(ImportRequest $request)
    {

        /** @var SiteImport|FileImport $importService */
        $importService = app(ImportBuilder::class, [$request])->build();
        $result = $importService->import();

        if ($result) {
            return redirect()
                ->route('mailer.maillist.index')
                ->with(['success' => 'Импорт успешно произведен']);
        } else {
            return back()
                ->withErrors(['error' => 'Не удалось произвести импорт'])
                ->withInput();
        }
    }


}
