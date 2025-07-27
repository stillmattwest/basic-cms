<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(rand(3, 8));
        $publishedAt = fake()->boolean(80) ? fake()->dateTimeBetween('-1 year', 'now') : null;
        
        return [
            // Basic content
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(rand(5, 15), true),
            'excerpt' => fake()->optional(0.7)->text(200),
            
            // Metadata
            'meta_title' => fake()->optional(0.6)->randomElement([
                $title, // Use exact title
                $title . ' | ' . fake()->words(2, true), // Title with suffix
                fake()->words(2, true) . ' ' . $title, // Title with prefix
                rtrim($title, '.') . ' - ' . fake()->word(), // Title with modifier
            ]),
            'meta_description' => fake()->optional(0.6)->text(160),
            'featured_image' => fake()->optional(0.4)->imageUrl(800, 400, 'articles'),
            'featured_image_alt' => fake()->optional(0.4)->sentence(3),
            
            // Status and visibility
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'published_at' => $publishedAt,
            'is_featured' => fake()->boolean(10), // 10% chance of being featured
            
            // User relationship
            'user_id' => User::factory(),
        ];
    }

    /**
     * Create a published post
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Create a draft post
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Create a featured post
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
            'featured_image' => fake()->imageUrl(800, 400, 'featured'),
            'featured_image_alt' => fake()->sentence(3),
        ]);
    }

    /**
     * Create an archived post
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archived',
            'published_at' => fake()->dateTimeBetween('-2 years', '-6 months'),
        ]);
    }

    /**
     * Create a post with full SEO data
     */
    public function withSeo(): static
    {
        return $this->state(fn (array $attributes) => [
            'meta_title' => fake()->sentence(rand(4, 8)),
            'meta_description' => fake()->text(150),
            'featured_image' => fake()->imageUrl(800, 400, 'seo'),
            'featured_image_alt' => fake()->sentence(3),
        ]);
    }
}
