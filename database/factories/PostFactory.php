<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = rtrim($this->faker->sentence(5), '.');

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1, 999999),
            'content' => $this->faker->paragraphs(3, true),
            'image_path' => null,
            'is_published' => true,
            'published_at' => now()->subDay(),
        ];
    }

    public function draft(): static
    {
        return $this->state([
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state([
            'is_published' => true,
            'published_at' => now()->addWeek(),
        ]);
    }
}
