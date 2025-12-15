<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Dashboard demo data
        $this->call([
            DashboardTableSeeder::class,
            AnalyticsTableSeeder::class,
            FintechTableSeeder::class,
        ]);

        // Mosaic Module Seeders - DO NOT EDIT THIS SECTION MANUALLY
        $this->call([
        ]);
        // End Mosaic Module Seeders
    }
}
