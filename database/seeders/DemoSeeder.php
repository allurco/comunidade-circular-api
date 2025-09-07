<?php

namespace Database\Seeders;

use App\Models\Exchange;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 10 users
        $users = User::factory()->count(10)->create();

        // 100 items (10 each roughly)
        Item::factory()->count(100)->create();

        // 30 exchanges
        Exchange::factory()->count(30)->create();
    }
}
