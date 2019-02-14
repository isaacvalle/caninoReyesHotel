<?php

use Illuminate\Database\Seeder;

use App\Models\Municipality;
class MunicipalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Municipality::truncate();

        $faker = \Faker\Factory::create();

        //iteration to create 15 fake records
        for ($i = 0; $i < 15; $i++) {
        	Municipality::create([
        		'name' => $faker->city,
        	]);
        }
    }
}
