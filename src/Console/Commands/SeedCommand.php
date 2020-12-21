<?php

declare(strict_types=1);

namespace Cortex\Bookings\Console\Commands;

use Illuminate\Console\Command;
use Cortex\Bookings\Database\Seeders\CortexBookingsSeeder;

class SeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Cortex Bookings Data.';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function handle(): void
    {
        $this->alert($this->description);

        $this->call('db:seed', ['--class' => CortexBookingsSeeder::class]);

        $this->line('');
    }
}
