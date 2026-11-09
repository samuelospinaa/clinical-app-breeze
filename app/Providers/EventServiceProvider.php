<?php

namespace App\Providers;

use App\Observers\LogObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
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

        $models = [
            'App\Models\Appointment',
            'App\Models\AppointmentType',
            'App\Models\Banner',
            'App\Models\ClinicalHistory',
            'App\Models\HistoryPatient',
            'App\Models\Message',
            'App\Models\Order',
            'App\Models\Pack',
            'App\Models\Patient',
            'App\Models\Professional',
            'App\Models\Role',
            'App\Models\SelectOption',
            'App\Models\Service',
            'App\Models\Testimony',
            'App\Models\User',

        ];

        foreach ($models as $model) {
            $model::observe(LogObserver::class);
        }
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
