<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'category_id' => Category::inRandomOrder()->first()->id, // Assign a random category
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
            'video' => $this->faker->url, // Placeholder for video URLs
            'status' => $this->faker->boolean, // Random true/false
        ];
    }
}
