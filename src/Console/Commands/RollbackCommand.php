<?php

declare(strict_types=1);

namespace Cortex\Bookings\Console\Commands;

use Rinvex\Bookings\Console\Commands\RollbackCommand as BaseRollbackCommand;

class RollbackCommand extends BaseRollbackCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:rollback:bookings {--f|force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback Cortex Bookings Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $path = config('cortex.bookings.autoload_migrations') ?
            'app/cortex/bookings/database/migrations' :
            'database/migrations/cortex/bookings';

        if (file_exists($path)) {
            $this->call('migrate:reset', [
                '--path' => $path,
                '--force' => $this->option('force'),
            ]);
        } else {
            $this->warn('No migrations found! Consider publish them first: <fg=green>php artisan cortex:publish:bookings</>');
        }

        parent::handle();
    }
}
