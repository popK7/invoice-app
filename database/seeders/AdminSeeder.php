<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credentials = [
            'first_name' => 'Invoika',
            'last_name'  => 'Admin',
            'username' => 'admin',
            'email'      => 'admin@themesbrand.com',
            'password' => '123456',
            'mobile_number' => '9876543210',
            'token'      => 'asdasdajskdd456465d4f5gsdf',
            'profile_image'=> 'avatar-1.jpg',
            'country' => 'India',
            'is_verified'=> 1,
        ];
        $admin = Sentinel::registerAndActivate( $credentials );
        $role = Sentinel::findRoleBySlug('admin');
        $role->users()->attach($admin);
    }
}
