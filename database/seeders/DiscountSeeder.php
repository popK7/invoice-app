<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Discount;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discount')->insert([
            'name' => 'First Purchase',
            'rate'  => 10.00,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
