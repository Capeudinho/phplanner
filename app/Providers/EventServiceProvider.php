<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\TaskEndingSoon::class => [ 
            \App\Listeners\SendTaskEndingMail::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}


