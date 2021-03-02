<?php

declare(strict_types=1);

namespace Cortex\Bookings\Providers;

use Illuminate\Routing\Router;
use Cortex\Bookings\Models\Event;
use Cortex\Bookings\Models\Service;
use Cortex\Bookings\Models\EventTicket;
use Cortex\Bookings\Models\ServiceRate;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Cortex\Bookings\Models\EventBooking;
use Cortex\Bookings\Models\ServiceBooking;
use Illuminate\Contracts\Events\Dispatcher;
use Cortex\Bookings\Models\ServiceAvailability;
use Illuminate\Database\Eloquent\Relations\Relation;

class BookingsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register(): void
    {
        // Bind eloquent models to IoC container
        $this->registerModels([
            'cortex.bookings.service' => Service::class,
            'cortex.bookings.service_availability' => ServiceAvailability::class,
            'cortex.bookings.service_booking' => ServiceBooking::class,
            'cortex.bookings.service_rate' => ServiceRate::class,
            'cortex.bookings.event' => Event::class,
            'cortex.bookings.event_ticket' => EventTicket::class,
            'cortex.bookings.event_booking' => EventBooking::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router, Dispatcher $dispatcher): void
    {
        // Bind route models and constrains
        $router->pattern('service', '[a-zA-Z0-9-_]+');
        $router->pattern('service_rate', '[a-zA-Z0-9-_]+');
        $router->pattern('service_booking', '[a-zA-Z0-9-_]+');
        $router->pattern('service_availability', '[a-zA-Z0-9-_]+');
        $router->pattern('event_booking', '[a-zA-Z0-9-_]+');
        $router->pattern('event_ticket', '[a-zA-Z0-9-_]+');
        $router->pattern('event', '[a-zA-Z0-9-_]+');

        $router->model('service', config('cortex.bookings.models.service'));
        $router->model('service_rate', config('cortex.bookings.models.service_rate'));
        $router->model('service_booking', config('cortex.bookings.models.service_booking'));
        $router->model('service_availability', config('cortex.bookings.models.service_availability'));
        $router->model('event_booking', config('cortex.bookings.models.event_booking'));
        $router->model('event_ticket', config('cortex.bookings.models.event_ticket'));
        $router->model('event', config('cortex.bookings.models.event'));

        // Map relations
        Relation::morphMap([
            'service' => config('cortex.bookings.models.service'),
            'service_rate' => config('cortex.bookings.models.service_rate'),
            'service_booking' => config('cortex.bookings.models.service_booking'),
            'service_availability' => config('cortex.bookings.models.service_availability'),
            'event_booking' => config('cortex.bookings.models.event_booking'),
            'event_ticket' => config('cortex.bookings.models.event_ticket'),
            'event' => config('cortex.bookings.models.event'),
        ]);
    }
}
