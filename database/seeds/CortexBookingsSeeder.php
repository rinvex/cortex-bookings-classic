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
        Bouncer::allow('admin')->to('import', config('cortex.bookings.models.room'));
        Bouncer::allow('admin')->to('create', config('cortex.bookings.models.room'));
        Bouncer::allow('admin')->to('update', config('cortex.bookings.models.room'));
        Bouncer::allow('admin')->to('delete', config('cortex.bookings.models.room'));
        Bouncer::allow('admin')->to('audit', config('cortex.bookings.models.room'));

        Bouncer::allow('admin')->to('list', config('cortex.bookings.models.event'));
        Bouncer::allow('admin')->to('import', config('cortex.bookings.models.event'));
        Bouncer::allow('admin')->to('create', config('cortex.bookings.models.event'));
        Bouncer::allow('admin')->to('update', config('cortex.bookings.models.event'));
        Bouncer::allow('admin')->to('delete', config('cortex.bookings.models.event'));
        Bouncer::allow('admin')->to('audit', config('cortex.bookings.models.event'));

        Bouncer::allow('admin')->to('list', config('cortex.bookings.models.event_ticket'));
        Bouncer::allow('admin')->to('create', config('cortex.bookings.models.event_ticket'));
        Bouncer::allow('admin')->to('update', config('cortex.bookings.models.event_ticket'));
        Bouncer::allow('admin')->to('delete', config('cortex.bookings.models.event_ticket'));
        Bouncer::allow('admin')->to('audit', config('cortex.bookings.models.event_ticket'));

        Bouncer::allow('admin')->to('list', config('cortex.bookings.models.room_addon'));
        Bouncer::allow('admin')->to('import', config('cortex.bookings.models.room_addon'));
        Bouncer::allow('admin')->to('create', config('cortex.bookings.models.room_addon'));
        Bouncer::allow('admin')->to('update', config('cortex.bookings.models.room_addon'));
        Bouncer::allow('admin')->to('delete', config('cortex.bookings.models.room_addon'));
        Bouncer::allow('admin')->to('audit', config('cortex.bookings.models.room_addon'));

        Bouncer::allow('admin')->to('list', config('cortex.bookings.models.room_rate'));
        Bouncer::allow('admin')->to('import', config('cortex.bookings.models.room_rate'));
        Bouncer::allow('admin')->to('create', config('cortex.bookings.models.room_rate'));
        Bouncer::allow('admin')->to('update', config('cortex.bookings.models.room_rate'));
        Bouncer::allow('admin')->to('delete', config('cortex.bookings.models.room_rate'));
        Bouncer::allow('admin')->to('audit', config('cortex.bookings.models.room_rate'));

        Bouncer::allow('admin')->to('list', config('cortex.bookings.models.room_availability'));
        Bouncer::allow('admin')->to('import', config('cortex.bookings.models.room_availability'));
        Bouncer::allow('admin')->to('create', config('cortex.bookings.models.room_availability'));
        Bouncer::allow('admin')->to('update', config('cortex.bookings.models.room_availability'));
        Bouncer::allow('admin')->to('delete', config('cortex.bookings.models.room_availability'));
        Bouncer::allow('admin')->to('audit', config('cortex.bookings.models.room_availability'));

        Bouncer::allow('owner')->to('list', config('cortex.bookings.models.room'));
        Bouncer::allow('owner')->to('import', config('cortex.bookings.models.room'));
        Bouncer::allow('owner')->to('create', config('cortex.bookings.models.room'));
        Bouncer::allow('owner')->to('update', config('cortex.bookings.models.room'));
        Bouncer::allow('owner')->to('delete', config('cortex.bookings.models.room'));
        Bouncer::allow('owner')->to('audit', config('cortex.bookings.models.room'));

        Bouncer::allow('owner')->to('list', config('cortex.bookings.models.event'));
        Bouncer::allow('owner')->to('import', config('cortex.bookings.models.event'));
        Bouncer::allow('owner')->to('create', config('cortex.bookings.models.event'));
        Bouncer::allow('owner')->to('update', config('cortex.bookings.models.event'));
        Bouncer::allow('owner')->to('delete', config('cortex.bookings.models.event'));
        Bouncer::allow('owner')->to('audit', config('cortex.bookings.models.event'));

        Bouncer::allow('owner')->to('list', config('cortex.bookings.models.event_ticket'));
        Bouncer::allow('owner')->to('create', config('cortex.bookings.models.event_ticket'));
        Bouncer::allow('owner')->to('update', config('cortex.bookings.models.event_ticket'));
        Bouncer::allow('owner')->to('delete', config('cortex.bookings.models.event_ticket'));
        Bouncer::allow('owner')->to('audit', config('cortex.bookings.models.event_ticket'));

        Bouncer::allow('owner')->to('list', config('cortex.bookings.models.room_addon'));
        Bouncer::allow('owner')->to('import', config('cortex.bookings.models.room_addon'));
        Bouncer::allow('owner')->to('create', config('cortex.bookings.models.room_addon'));
        Bouncer::allow('owner')->to('update', config('cortex.bookings.models.room_addon'));
        Bouncer::allow('owner')->to('delete', config('cortex.bookings.models.room_addon'));
        Bouncer::allow('owner')->to('audit', config('cortex.bookings.models.room_addon'));

        Bouncer::allow('owner')->to('list', config('cortex.bookings.models.room_rate'));
        Bouncer::allow('owner')->to('import', config('cortex.bookings.models.room_rate'));
        Bouncer::allow('owner')->to('create', config('cortex.bookings.models.room_rate'));
        Bouncer::allow('owner')->to('update', config('cortex.bookings.models.room_rate'));
        Bouncer::allow('owner')->to('delete', config('cortex.bookings.models.room_rate'));
        Bouncer::allow('owner')->to('audit', config('cortex.bookings.models.room_rate'));

        Bouncer::allow('owner')->to('list', config('cortex.bookings.models.room_availability'));
        Bouncer::allow('owner')->to('import', config('cortex.bookings.models.room_availability'));
        Bouncer::allow('owner')->to('create', config('cortex.bookings.models.room_availability'));
        Bouncer::allow('owner')->to('update', config('cortex.bookings.models.room_availability'));
        Bouncer::allow('owner')->to('delete', config('cortex.bookings.models.room_availability'));
        Bouncer::allow('owner')->to('audit', config('cortex.bookings.models.room_availability'));
    }
}
