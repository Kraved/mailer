<?php

namespace App\Providers;

use App\Contracts\Maillist\Import\FileImport;
use App\Contracts\Maillist\Import\SiteImport;
use App\Services\Maillist\Import\SiteImportService;
use App\Services\Maillist\Import\TxtFileImportService;
use Illuminate\Support\ServiceProvider;

class MailListImportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            FileImport::class,
            TxtFileImportService::class
        );

        $this->app->bind(
            SiteImport::class,
            SiteImportService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
