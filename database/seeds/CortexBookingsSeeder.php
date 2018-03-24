<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class CortexBookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('admin')->to('list', config('cortex.bookings.models.room'));
        Bouncer::allow('admin')->to('create', config('cortex.bookings.models.room'));
        Bouncer::allow('admin')->to('update', config('cortex.bookings.models.room'));
        Bouncer::allow('admin')->to('delete', config('cortex.bookings.models.room'));
        Bouncer::allow('admin')->to('audit', config('cortex.bookings.models.room'));

        Bouncer::allow('admin')->to('list', config('rinvex.bookings.models.booking'));
        Bouncer::allow('admin')->to('create', config('rinvex.bookings.models.booking'));
        Bouncer::allow('admin')->to('update', config('rinvex.bookings.models.booking'));
        Bouncer::allow('admin')->to('delete', config('rinvex.bookings.models.booking'));
        Bouncer::allow('admin')->to('audit', config('rinvex.bookings.models.booking'));
    }
}
