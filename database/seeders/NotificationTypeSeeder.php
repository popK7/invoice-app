<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notification_types = [
            [
                'type' => "New Client Added",
                'created_at' => now(),
            ],
            [
                'type' => "New Product Added",
                'created_at' => now(),
            ],
            [
                'type' => "Product Updated",
                'created_at' => now(),
            ],
            [
                'type' => "New Tax Added",
                'created_at' => now(),
            ],
            [
                'type' => "New Discount Added",
                'created_at' => now(),
            ],
            [
                'type' => "New Company Added",
                'created_at' => now(),
            ],
            [
                'type' => "Tax Is Updated",
                'created_at' => now(),
            ],
            [
                'type' => "Discount Is Updated",
                'created_at' => now(),
            ],
            [
                'type' => "Shipping Charge Is Updated",
                'created_at' => now(),
            ],
        ];
        DB::table('notification_types')->insert($notification_types);
    }
}
