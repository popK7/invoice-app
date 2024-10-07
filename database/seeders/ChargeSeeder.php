<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ShippingCharge;

class ChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_charge')->insert([
            'name' => 'Shipping Charge',
            'country' => 'India',
            'rate'  => 12.00,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
