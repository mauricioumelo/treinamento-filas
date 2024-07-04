<?php

namespace Database\Factories;

use App\PostStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            "descricao" => $this->faker->text(255),
            "status" => PostStatus::EM_PROCESSAMENTO
        ];
    }
}
