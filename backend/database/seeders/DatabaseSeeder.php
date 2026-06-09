<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            VenueSeeder::class,
            FleetSeeder::class,
            CompanionSeeder::class,
            DemoBookingSeeder::class,
        ]);
    }
}
