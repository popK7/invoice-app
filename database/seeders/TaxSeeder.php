<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tax;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tax')->insert([
            'name' => 'GST',
            'country' => 'India',
            'rate'  => 18.00,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
