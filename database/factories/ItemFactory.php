<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cats = ['Livros','Eletrônicos','Roupas','Móveis','Esporte'];
        return [
            'owner_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => fake()->words(3, true),
            'category' => fake()->randomElement($cats),
            'conservation' => fake()->randomElement(['Novo','Usado','Bom','Defeituoso']),
            'description' => fake()->paragraph(),
            'district' => fake()->citySuffix(),
            'lat' => fake()->randomFloat(7, -33.0, 5.0),
            'lng' => fake()->randomFloat(7, -73.0, -34.0),
            'photo' => null,
            'status' => 'Disponivel',
        ];
    }
}
