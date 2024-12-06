<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advertisement;

class AdvertisementSeeder extends Seeder
{
    public function run()
    {
        // Generate 100 advertisement records
        Advertisement::factory(100)->create();
    }
}
