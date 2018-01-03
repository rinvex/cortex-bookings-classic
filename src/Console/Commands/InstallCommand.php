<?php

declare(strict_types=1);

namespace Cortex\Bookings\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:install:bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Cortex Bookings Module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn($this->description);

        $this->call('cortex:migrate:bookings');
        $this->call('cortex:seed:bookings');
        $this->call('cortex:publish:bookings');
    }
}
