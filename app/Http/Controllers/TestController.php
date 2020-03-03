<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory as Faker;

class TestController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function test()
    {
        $generator = Faker::create();
        dd($generator->email);
    }


}
