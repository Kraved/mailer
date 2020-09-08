<?php

namespace App\Providers;

use App\Contracts\Maillist\Export\MailListExport;
use App\Services\Maillist\Export\TxtFileExportService;
use Illuminate\Support\ServiceProvider;

/**
 * Class MailListExportServiceProvider
 * @package App\Providers
 */
class MailListExportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MailListExport::class, TxtFileExportService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
