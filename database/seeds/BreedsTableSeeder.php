<?php

use Illuminate\Database\Seeder;

use App\Models\Breed;
class BreedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Breed::truncate();

        $faker = \Faker\Factory::create();

        //iteration to create 20 fake records
        for ($i = 0; $i < 20; $i++) {
        	Breed::create([
        		'name' => $faker->word,
        	]);
        }
    }
}
