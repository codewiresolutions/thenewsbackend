<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true), // Generates a random name
            'description' => $this->faker->sentence(), // Generates a random sentence
            'video' => 'videos/' . $this->faker->uuid() . '.mp4', // Simulate video file path
            'image' => 'images/' . $this->faker->uuid() . '.jpg', // Simulate image file path
            'active' => $this->faker->boolean(), // Randomly true or false
        ];
    }
}
