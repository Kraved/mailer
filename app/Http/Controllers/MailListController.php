<?php

namespace App\Http\Controllers;

use App\Models\MailList;
use App\Repository\MailListRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd(__METHOD__, $id);
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
        $result = $mailList->find($id)->update($data);
        if($result){
            return redirect(route('mailer.maillist.index'))
                ->with(['msg' => 'Почта успешно изменения']);
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
        $result = $mailList->find($id)->delete();
        if($result){
            return redirect(route('mailer.maillist.index'))
                ->with(['msg' => 'Почта успешно удалена']);
        } else {
            return back()
                ->withErrors(['error1' => 'Ошибка удаления']);
        }

    }
}
