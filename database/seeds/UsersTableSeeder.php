<?php

use Illuminate\Database\Seeder;

use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();

        $faker = \Faker\Factory::create();

        $password = Hash::make('admin123');

        //create the first record like admin
        User::create([
        	'name' => 'Administrador',
        	'last_name' => 'LastName',
        	'mother_last_name' => 'MotherLastName',
        	'phone' => '3234567',
        	'mobile' => '3121234567',
        	'email' => 'admin@test.com',
        	'password' => $password,
            'picture' => $faker->imageUrl($width = 600, $height = 420),
        ]);

        //iteration to create 10 fake records
        for ($i = 0; $i < 10; $i++) {
        	User::create([
        		'name' => $faker->name,
        		'last_name' => $faker->lastName,
        		'mother_last_name' => $faker->lastName,
        		'phone' => $faker->phoneNumber,
        		'mobile' => $faker->phoneNumber,
        		'email' => $faker->email,
        		'password' => $password,
                'picture' => $faker->imageUrl($width = 600, $height = 420, 'cats'),
        	]);
        }
    }
}
