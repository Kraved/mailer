<?php

namespace App\Http\Controllers;

use App\Models\MailList;
use App\Repository\MailListRepository;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class TestController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function test(MailListRepository $listRepository)
    {
        $data = ['it@lexsystems.ru', '123', '123@asdas.ru'];
        $data = [];
        $result = $this->checkWithRegExp($data);
        dd($result);
    }

    public function checkWithRegExp(array $data)
    {
        $pattern = "/^[A-Za-z0-9][A-Za-z0-9\.\-_]*[A-Za-z0-9]*@([A-Za-z0-9]+([A-Za-z0-9-]*[A-Za-z0-9]+)*\.)+[A-Za-z]*$/";
        $mails = preg_grep($pattern, $data);
        if (empty($mails)) {
            return false;
        }else{
            return $mails;
        }
    }

}
