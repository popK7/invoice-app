<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class AccountantSeeder extends Seeder
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
            'last_name'  => 'Accountant',
            'username'   => 'accountant',
            'email'      => 'accountant@themesbrand.com',
            'password'   => '123456',
            'mobile_number' => '9876543210',
            'profile_image' => 'avatar-2.jpg',
            'country' => 'India',
            'token'      => 'asdasdajskdd456465d4f5gsdf',
            'created_by' => 1,
            'is_verified'=> 1,
        ];
        $accountant = Sentinel::registerAndActivate( $credentials );
        $role = Sentinel::findRoleBySlug('accountant');
        $role->users()->attach($accountant);
    }
}
