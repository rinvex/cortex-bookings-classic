<?php

declare(strict_types=1);

namespace Cortex\Bookings\Console\Commands;

use Illuminate\Console\Command;
use Rinvex\Support\Traits\SeederHelper;

class SeedCommand extends Command
{
    use SeederHelper;

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
        $this->warn($this->description);

        if ($this->ensureExistingDatabaseTables('rinvex/fort')) {
            $this->seedResources(app('rinvex.fort.ability'), realpath(__DIR__.'/../../../resources/data/abilities.json'), ['name', 'description', 'policy']);
        }
    }
}
