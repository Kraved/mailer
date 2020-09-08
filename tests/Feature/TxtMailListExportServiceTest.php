<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TxtMailListExportServiceTest extends TestCase
{
    use WithoutMiddleware;


    public function testTxtMailListExportServiceTest()
    {

        $this->withoutMiddleware();

        $response = $this
            ->get(route('mailer.maillist.export'));

        $response->assertOk();
        $response->assertHeader('Content-Disposition', "attachment; filename=export.txt");
    }
}
