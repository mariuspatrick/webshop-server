<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

use App\Models\Product;
// use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Schema::dropColumns();
        $json = File::get('database/data/products.json');
        $data = json_decode($json);

        foreach ($data as $obj) {
            Product::create(array(
                'title' => $obj->name,
                'price' => $obj->price,
                'description' => $obj->description,
                'quantity' => $obj->quantity,
            ));
        }
    }
}
