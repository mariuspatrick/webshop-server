<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Product::factory()->count(25)->create()->each(function ($product) {
            $product->save();
        });
    }
}
