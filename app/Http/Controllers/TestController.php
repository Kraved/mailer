<?php

namespace App\Http\Controllers;

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

        dd($listRepository->getAllWithPaginate(10));
    }


}
