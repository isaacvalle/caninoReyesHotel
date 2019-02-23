<?php

use Illuminate\Database\Seeder;

use App\Models\State;
class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // State::truncate();

        $faker = \Faker\Factory::create();

        //iteration to create 10 fake records
        for ($i = 0; $i < 10; $i++) {
        	State::create([
        		'name' => $faker->state,
        	]);
        }
    }
}
