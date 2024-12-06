<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdvertisementSeeder::class, // Calls the advertisement seeder
            TagSeeder::class,           // Include the TagSeeder
        ]);
    }
}
