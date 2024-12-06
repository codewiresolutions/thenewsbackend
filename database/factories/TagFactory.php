<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = \App\Models\Tag::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Generate random words for tags
        ];
    }
}