<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CompanyDetails;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_details')->insert([
            'company_name' => 'ABC India Pvt Ltd',
            'website' => 'http://www.abc.com',
            'email'  => 'abc@gmail.com',
            'mobile_number' => 9876543210,
            'postalcode' => 369258,
            'address' => '100,New Abc,Gujrat,India',
            'logo' => 'abc.png',
            'invoice_slug' => 'ABC',
            'status' => 1,
        ]);
    }
}
