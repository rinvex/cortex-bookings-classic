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
    protected $signature = 'cortex:rollback:bookings {--force : Force the operation to run when in production.}';

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
        $this->call('migrate:reset', ['--path' => 'app/cortex/bookings/database/migrations', '--force' => $this->option('force')]);

        parent::handle();
    }
}
