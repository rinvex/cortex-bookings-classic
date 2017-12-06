<?php

declare(strict_types=1);

namespace Cortex\Bookings\Console\Commands;

use Rinvex\Bookings\Console\Commands\PublishCommand as BasePublishCommand;

class PublishCommand extends BasePublishCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:bookings {--force : Overwrite any existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Bookings Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        $this->call('vendor:publish', ['--tag' => 'cortex-bookings-views', '--force' => $this->option('force')]);
        $this->call('vendor:publish', ['--tag' => 'cortex-bookings-lang', '--force' => $this->option('force')]);
    }
}
