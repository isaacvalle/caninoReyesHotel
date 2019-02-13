<?php

use Illuminate\Database\Seeder;

use App\Models\Address;
class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Color::truncate();

        $faker = \Faker\Factory::create();  

        //iteration to create 15 fake records
        for ($i = 0; $i < 15; $i++) {
        	Address::create([
                'number' => $faker->numberBetween($min = 100, $max = 1000),
                'int_number' => $faker->numberBetween($min = 100, $max = 200),
        		'street_id' => $faker->numberBetween($min = 1, $max = 30),
        		'locality_id' => $faker->numberBetween($min = 1, $max = 20),
        		'municipality_id' => $faker->numberBetween($min = 1, $max = 15),
        		'state_id' => $faker->numberBetween($min = 1, $max = 10),
        		'reference' => $faker->sentence,
        		'zip_code_id' => $faker->numberBetween($min = 1, $max = 15),
        		'mapsLocation' => $faker->url,
        	]);
        }
    }
}
