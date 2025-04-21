<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Use the user@example.com (Testing purpose)
        Cart::updateOrCreate(
            [
                'user_id'=>2
            ]
        );
    }
}
