<?php

declare(strict_types=1);

return [

    // Bookings database tables
    'tables' => [
        'rooms' => 'rooms',
    ],

    // Bookings models
    'models' => [
        'room' => \Cortex\Bookings\Models\Room::class,
    ],

];
