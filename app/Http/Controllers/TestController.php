<?php

namespace App\Http\Controllers;

use App\Models\MailList;
use App\Repository\MailListRepository;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function test(MailListRepository $repository)
    {
        $data = $repository->getMailToExport();
        $tmpFile = tempnam("/tmp","");
        foreach ($data as $line)
            file_put_contents($tmpFile, $line , FILE_APPEND);
        return response()->download($tmpFile, 'export.txt');
    }

}
