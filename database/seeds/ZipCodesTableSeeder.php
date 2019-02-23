<?php

use Illuminate\Database\Seeder;

use App\Models\ZipCode;
class ZipCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ZipCode::truncate();

        $faker = \Faker\Factory::create();

        //iteration to create 15 fake records
        for ($i = 0; $i < 15; $i++) {
        	ZipCode::create([
        		'zip_code' => $faker->postcode,
        	]);
        }
    }
}
