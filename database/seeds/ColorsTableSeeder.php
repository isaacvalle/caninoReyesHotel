<?php

use Illuminate\Database\Seeder;

use App\Models\Color;
class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Color::truncate();

        $faker = \Faker\Factory::create();

        //iteration to create 15 fake records
        for ($i = 0; $i < 15; $i++) {
        	Color::create([
        		'color' => $faker->colorName,
        	]);
        }
    }
}
