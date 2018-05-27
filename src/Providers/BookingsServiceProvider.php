<?php

declare(strict_types=1);

namespace Cortex\Bookings\Providers;

use Illuminate\Routing\Router;
use Cortex\Bookings\Models\Room;
use Cortex\Bookings\Models\Event;
use Cortex\Bookings\Models\RoomRate;
use Cortex\Bookings\Models\RoomAddon;
use Cortex\Bookings\Models\EventTicket;
use Cortex\Bookings\Models\RoomBooking;
use Illuminate\Support\ServiceProvider;
use Cortex\Bookings\Models\EventBooking;
use Cortex\Bookings\Models\RoomAvailability;
use Cortex\Bookings\Console\Commands\SeedCommand;
use Cortex\Bookings\Console\Commands\InstallCommand;
use Cortex\Bookings\Console\Commands\MigrateCommand;
use Cortex\Bookings\Console\Commands\PublishCommand;
use Illuminate\Database\Eloquent\Relations\Relation;
use Cortex\Bookings\Console\Commands\RollbackCommand;

class BookingsServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        SeedCommand::class => 'command.cortex.bookings.seed',
        InstallCommand::class => 'command.cortex.bookings.install',
        MigrateCommand::class => 'command.cortex.bookings.migrate',
        PublishCommand::class => 'command.cortex.bookings.publish',
        RollbackCommand::class => 'command.cortex.bookings.rollback',
    ];

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
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'cortex.bookings');

        // Bind eloquent models to IoC container
        $this->app->singleton('cortex.bookings.room', $bookableAddonModel = $this->app['config']['cortex.bookings.models.room']);
        $bookableAddonModel === Room::class || $this->app->alias('cortex.bookings.room', Room::class);

        $this->app->singleton('cortex.bookings.room_addon', $bookableAddonModel = $this->app['config']['cortex.bookings.models.room_addon']);
        $bookableAddonModel === RoomAddon::class || $this->app->alias('cortex.bookings.room_addon', RoomAddon::class);

        $this->app->singleton('cortex.bookings.room_availability', $bookableAvailabilityModel = $this->app['config']['cortex.bookings.models.room_availability']);
        $bookableAvailabilityModel === RoomAvailability::class || $this->app->alias('cortex.bookings.room_availability', RoomAvailability::class);

        $this->app->singleton('cortex.bookings.room_booking', $bookableAvailabilityModel = $this->app['config']['cortex.bookings.models.room_booking']);
        $bookableAvailabilityModel === RoomBooking::class || $this->app->alias('cortex.bookings.room_booking', RoomBooking::class);

        $this->app->singleton('cortex.bookings.room_rate', $bookableRateModel = $this->app['config']['cortex.bookings.models.room_rate']);
        $bookableRateModel === RoomRate::class || $this->app->alias('cortex.bookings.room_rate', RoomRate::class);

        $this->app->singleton('cortex.bookings.event', $bookableAvailabilityModel = $this->app['config']['cortex.bookings.models.event']);
        $bookableAvailabilityModel === Event::class || $this->app->alias('cortex.bookings.event', Event::class);

        $this->app->singleton('cortex.bookings.event_ticket', $bookableAvailabilityModel = $this->app['config']['cortex.bookings.models.event_ticket']);
        $bookableAvailabilityModel === EventTicket::class || $this->app->alias('cortex.bookings.event_ticket', EventTicket::class);

        $this->app->singleton('cortex.bookings.event_booking', $bookableRateModel = $this->app['config']['cortex.bookings.models.event_booking']);
        $bookableRateModel === EventBooking::class || $this->app->alias('cortex.bookings.event_booking', EventBooking::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();

        // Bind eloquent models to IoC container
        $this->app->singleton('cortex.bookings.room', $roomModel = $this->app['config']['cortex.bookings.models.room']);
        $roomModel === Room::class || $this->app->alias('cortex.bookings.room', Room::class);

        $this->app->singleton('cortex.bookings.event', $eventModel = $this->app['config']['cortex.bookings.models.event']);
        $eventModel === Event::class || $this->app->alias('cortex.bookings.event', Event::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router): void
    {
        // Bind route models and constrains
        $router->pattern('room', '[a-zA-Z0-9-]+');
        $router->pattern('room_rate', '[a-zA-Z0-9-]+');
        $router->pattern('room_addon', '[a-zA-Z0-9-]+');
        $router->pattern('room_booking', '[a-zA-Z0-9-]+');
        $router->pattern('room_availability', '[a-zA-Z0-9-]+');
        $router->pattern('event_booking', '[a-zA-Z0-9-]+');
        $router->pattern('event_ticket', '[a-zA-Z0-9-]+');
        $router->pattern('event', '[a-zA-Z0-9-]+');

        $router->model('room', config('cortex.bookings.models.room'));
        $router->model('room_rate', config('cortex.bookings.models.room_rate'));
        $router->model('room_addon', config('cortex.bookings.models.room_addon'));
        $router->model('room_booking', config('cortex.bookings.models.room_booking'));
        $router->model('room_availability', config('cortex.bookings.models.room_availability'));
        $router->model('event_booking', config('cortex.bookings.models.event_booking'));
        $router->model('event_ticket', config('cortex.bookings.models.event_ticket'));
        $router->model('event', config('cortex.bookings.models.event'));

        // Map relations
        Relation::morphMap([
            'room' => config('cortex.bookings.models.room'),
            'room_rate' => config('cortex.bookings.models.room_rate'),
            'room_addon' => config('cortex.bookings.models.room_addon'),
            'room_booking' => config('cortex.bookings.models.room_booking'),
            'room_availability' => config('cortex.bookings.models.room_availability'),
            'event_booking' => config('cortex.bookings.models.event_booking'),
            'event_ticket' => config('cortex.bookings.models.event_ticket'),
            'event' => config('cortex.bookings.models.event'),
        ]);

        // Load resources
        require __DIR__.'/../../routes/breadcrumbs/adminarea.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/adminarea.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/managerarea.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/bookings');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/bookings');
        ! $this->app->runningInConsole() || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->app->runningInConsole() || $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus/managerarea.php';
            require __DIR__.'/../../routes/menus/adminarea.php';
        });

        // Publish resources
        ! $this->app->runningInConsole() || $this->publishResources();
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources(): void
    {
        $this->publishes([realpath(__DIR__.'/../../database/migrations') => database_path('migrations')], 'cortex-bookings-migrations');
        $this->publishes([realpath(__DIR__.'/../../config/config.php') => config_path('cortex.bookings.php')], 'cortex-bookings-config');
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/bookings')], 'cortex-bookings-lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/bookings')], 'cortex-bookings-views');
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->app->singleton($value, $key);
        }

        $this->commands(array_values($this->commands));
    }
}
