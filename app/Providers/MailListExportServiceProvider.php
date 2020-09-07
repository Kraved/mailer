<?php

namespace App\Providers;

use App\Contracts\MailListExport;
use App\Services\TxtMailListExportService;
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
        $this->app->bind(MailListExport::class, TxtMailListExportService::class);
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
