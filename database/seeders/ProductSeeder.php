<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'brand_id' => 1,
            'product_name' => 'Lawman T-shirt',
            'category_id'  => 1,
            'price' => 200.00,
            'color_id' => 1,
            'description' => 'Mens T-shirt',
            'product_image' => 'img-1.png',
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
