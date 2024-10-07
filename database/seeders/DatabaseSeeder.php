<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\AccountantSeeder;
use Database\Seeders\ClientSeeder;
use Database\Seeders\NotificationTypeSeeder;
use Database\Seeders\SiteSettingSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\InvoiceSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TaxSeeder;
use Database\Seeders\DiscountSeeder;
use Database\Seeders\ChargeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            AccountantSeeder::class,
            ClientSeeder::class,
            NotificationTypeSeeder::class,
            SiteSettingSeeder::class,
            CompanySeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ColorSeeder::class,
            ProductSeeder::class,
            TaxSeeder::class,
            DiscountSeeder::class,
            ChargeSeeder::class,
            InvoiceSeeder::class,
       ]);
    }
}
