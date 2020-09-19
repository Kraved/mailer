<?php

namespace App\Providers;

use App\Services\Mailer\MailerService;
use App\Contracts\Mailer\Mailer;
use App\Services\Mailer\QueueAttachmentHandlerService;
use App\Services\Mailer\QueueHandlerService;
use App\Services\Mailer\SimpleAttachmentHandleService;
use App\Services\Mailer\SimpleHandlerService;
use Illuminate\Support\ServiceProvider;

class MailerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(Mailer::class, MailerService::class);
        $this->app->bind(QueueHandlerService::class, QueueHandlerService::class);
        $this->app->bind(QueueAttachmentHandlerService::class, QueueAttachmentHandlerService::class);
        $this->app->bind(SimpleHandlerService::class, SimpleHandlerService::class);
        $this->app->bind(SimpleAttachmentHandleService::class, SimpleAttachmentHandleService::class);
    }
}
