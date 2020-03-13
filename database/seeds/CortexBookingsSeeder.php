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
        $abilities = [
            ['name' => 'list', 'title' => 'List services', 'entity_type' => 'service'],
            ['name' => 'import', 'title' => 'Import services', 'entity_type' => 'service'],
            ['name' => 'create', 'title' => 'Create services', 'entity_type' => 'service'],
            ['name' => 'update', 'title' => 'Update services', 'entity_type' => 'service'],
            ['name' => 'delete', 'title' => 'Delete services', 'entity_type' => 'service'],
            ['name' => 'audit', 'title' => 'Audit services', 'entity_type' => 'service'],

            ['name' => 'list', 'title' => 'List event', 'entity_type' => 'event'],
            ['name' => 'import', 'title' => 'Import event', 'entity_type' => 'event'],
            ['name' => 'create', 'title' => 'Create event', 'entity_type' => 'event'],
            ['name' => 'update', 'title' => 'Update event', 'entity_type' => 'event'],
            ['name' => 'delete', 'title' => 'Delete event', 'entity_type' => 'event'],
            ['name' => 'audit', 'title' => 'Audit event', 'entity_type' => 'event'],

            ['name' => 'list', 'title' => 'List event tickets', 'entity_type' => 'event_ticket'],
            ['name' => 'import', 'title' => 'Import event tickets', 'entity_type' => 'event_ticket'],
            ['name' => 'create', 'title' => 'Create event tickets', 'entity_type' => 'event_ticket'],
            ['name' => 'update', 'title' => 'Update event tickets', 'entity_type' => 'event_ticket'],
            ['name' => 'delete', 'title' => 'Delete event tickets', 'entity_type' => 'event_ticket'],
            ['name' => 'audit', 'title' => 'Audit event tickets', 'entity_type' => 'event_ticket'],

            ['name' => 'list', 'title' => 'List service rates', 'entity_type' => 'service_rate'],
            ['name' => 'import', 'title' => 'Import service rates', 'entity_type' => 'service_rate'],
            ['name' => 'create', 'title' => 'Create service rates', 'entity_type' => 'service_rate'],
            ['name' => 'update', 'title' => 'Update service rates', 'entity_type' => 'service_rate'],
            ['name' => 'delete', 'title' => 'Delete service rates', 'entity_type' => 'service_rate'],
            ['name' => 'audit', 'title' => 'Audit service rates', 'entity_type' => 'service_rate'],

            ['name' => 'list', 'title' => 'List service availabilities', 'entity_type' => 'service_availability'],
            ['name' => 'import', 'title' => 'Import service availabilities', 'entity_type' => 'service_availability'],
            ['name' => 'create', 'title' => 'Create service availabilities', 'entity_type' => 'service_availability'],
            ['name' => 'update', 'title' => 'Update service availabilities', 'entity_type' => 'service_availability'],
            ['name' => 'delete', 'title' => 'Delete service availabilities', 'entity_type' => 'service_availability'],
            ['name' => 'audit', 'title' => 'Audit service availabilities', 'entity_type' => 'service_availability'],
        ];

        collect($abilities)->each(function (array $ability) {
            app('cortex.auth.ability')->firstOrCreate([
                'name' => $ability['name'],
                'entity_type' => $ability['entity_type'],
            ], $ability);
        });
    }
}
