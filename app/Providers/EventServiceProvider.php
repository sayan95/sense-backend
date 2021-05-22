<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Events\User\Therapist\TherapistRegisterdEvent;
use App\Events\User\Therapist\TherapistDeRegisterEvent;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\User\Therapist\TherapistAccountActivationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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

        // therapist registration event
        TherapistRegisterdEvent::class => [
            TherapistAccountActivationListener::class
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
