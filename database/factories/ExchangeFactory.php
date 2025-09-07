<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exchange>
 */
class ExchangeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $item = Item::inRandomOrder()->first() ?? Item::factory()->create();
        $from = User::inRandomOrder()->first() ?? User::factory()->create();
        $to   = User::where('id','<>',$from->id)->inRandomOrder()->first() ?? User::factory()->create();

        return [
            'from_user_id' => $from->id,
            'to_user_id'   => $to->id,
            'item_id'      => $item->id,
            'date' => now()->subDays(rand(0,15)),
            'notes' => fake()->sentence(),
            'type' => fake()->randomElement(['TROCA','DOACAO']),
            'status' => fake()->randomElement(['PENDENTE','ACEITA','CONCLUIDA']),
            'status_datetime' => now(),
            'avoided_items' => 1,
        ];

    }
}
