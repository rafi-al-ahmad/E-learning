<?php

namespace App\Providers;

use App\Events\ActivateAccount;
use App\Events\CloseAccount;
use App\Events\CreateModelEvent;
use App\Events\DeleteModelEvent;
use App\Events\UpdateModelEvent;
use App\Listeners\LogCreateMdelEventListener;
use App\Listeners\LogDeleteMdelEventListener;
use App\Listeners\LogUpdateMdelEventListener;
use App\Listeners\SendActivateAccountNotification;
use App\Listeners\SendClosedAccountNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CloseAccount::class => [
            SendClosedAccountNotification::class,
        ],
        ActivateAccount::class => [
            SendActivateAccountNotification::class,
        ],
        CreateModelEvent::class => [
            LogCreateMdelEventListener::class,
        ],
        DeleteModelEvent::class => [
            LogDeleteMdelEventListener::class,
        ],
        UpdateModelEvent::class => [
            LogUpdateMdelEventListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //

    }
}
