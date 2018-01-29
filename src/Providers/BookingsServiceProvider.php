<?php

declare(strict_types=1);

namespace Cortex\Bookings\Providers;

use Illuminate\Routing\Router;
use Cortex\Bookings\Models\Room;
use Rinvex\Bookings\Models\Booking;
use Illuminate\Support\ServiceProvider;
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

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();

        // Bind eloquent models to IoC container
        $this->app->singleton('cortex.bookings.room', $roomModel = $this->app['config']['cortex.bookings.models.room']);
        $roomModel === Room::class || $this->app->alias('cortex.bookings.room', Room::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router): void
    {
        // Bind route models and constrains
        $router->pattern('booking', '[0-9]+');
        $router->pattern('room', '[0-9a-z\._-]+');
        $router->model('room', Room::class);
        $router->model('booking', Booking::class);

        // Map relations
        Relation::morphMap([
            'room' => config('cortex.bookings.models.room'),
            'price' => config('rinvex.bookings.models.price'),
            'booking' => config('rinvex.bookings.models.booking'),
            'rate' => config('rinvex.bookings.models.rate'),
        ]);

        // Load resources
        require __DIR__.'/../../routes/breadcrumbs.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/bookings');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/bookings');
        ! $this->app->runningInConsole() || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus.php';
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
