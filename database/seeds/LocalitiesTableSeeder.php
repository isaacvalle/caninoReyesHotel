<?php

use Illuminate\Database\Seeder;

use App\Models\Locality;
class LocalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Locality::truncate();

        $faker = \Faker\Factory::create();

        //iteration to create 20 fake records
        for ($i = 0; $i < 20; $i++) {
        	Locality::create([
        		'name' => $faker->citySuffix,
        	]);
        }
    }
}
