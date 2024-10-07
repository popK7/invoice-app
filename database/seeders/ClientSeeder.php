<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as faker;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = faker::create();
        $country = ['Pakistan', 'Japan' , 'Argentina' , 'Australia' , 'France' , 'Kenya' ,'Pakistan', 'Japan' , 'Argentina' , 'Australia' , 'France' , 'Kenya'];

        $credentials = [
            'first_name' => 'Invoika',
            'last_name'  => 'Client',
            'username' => 'client',
            'email'      => 'client@themesbrand.com',
            'password' => '123456',
            'mobile_number' => '9876543210',
            'token'      => 'asdasdajskdd456465d4f5gsdf',
            'profile_image' => 'avatar-3.jpg',
            'country' => 'India',
            'created_by' => 2,
            'is_verified'=> 1,
        ];
        $client = Sentinel::registerAndActivate($credentials);
        $role = Sentinel::findRoleBySlug('client');
        $role->users()->attach($client);

        DB::table('client_details')->insert([
            'user_id' => 3,
            'company_name' => 'Themesbrand',
            'gst_number' => 'GST123456',
            'company_code' => '14526358',
            'address' => '404-B, Deepkamal 2, Nr, Sarthana Jakat Naka, Nature Park and Zoo, Surat, Gujarat 395006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach (range(4, 7) as $item) {
            $fakerName = $faker->name;
            $credentials = [
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'username' => $faker->userName,
                'email'      => $faker->safeEmail,
                'password' => '123456',
                'mobile_number' => rand(1000000000, 2000000000),
                'token'      => 'asdasdajskdd456465d4f5gsdf',
                'profile_image' => 'avatar-'.$item.'.jpg',
                'country' => $country[$item],
                'created_by' => 2,
                'is_verified'=> 1,
            ];
            $client = Sentinel::registerAndActivate($credentials);
            $role = Sentinel::findRoleBySlug('client');
            $role->users()->attach($client);
        }
        foreach (range(4, 7) as $item) {
            DB::table('client_details')->insert([
                'user_id' => $item,
                'company_name' => $faker->company,
                'gst_number' => 'GST'.rand(100000,900000),
                'company_code' => rand(10000000,90000000),
                'address' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
