<?php

namespace glasswalllab\keypayconnector\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use glasswalllab\keypayconnector\Events\ResponseReceived;
use glasswalllab\keypayconnector\Listeners\UpdateResponse;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ResponseReceived::class => [
            UpdateResponse::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}