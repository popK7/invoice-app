<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_settings')->insert([
            'app_title' => 'Invoika - Invoice Management Laravel System.',
            'light_logo' => 'logo-light.png',
            'dark_logo' => 'logo-dark.png',
            'favicon' => 'favicon.ico',
            'logo_sm' => 'logo-sm.png',
            'copyright_first' => 'Invoika.',
            'copyright_last' => 'Design & Develop by Themesbrand',
        ]);
    }
}
