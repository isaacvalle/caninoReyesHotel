<?php

use Illuminate\Database\Seeder;

use App\Models\Street;
class StreetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Street::truncate();

        $faker = \Faker\Factory::create();

        //iteration to create 30 fake records
        for ($i = 0; $i < 30; $i++) {
        	Street::create([
        		'name' => $faker->streetName,
        	]);
        }
    }
}
