<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run()
    {
        // Generate 100 tags using the factory
        Tag::factory()->count(100)->create();
    }
}
