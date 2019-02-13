<?php

use Illuminate\Database\Seeder;

use App\Models\WeightHistory;
class WeightHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //WeightHistory::truncate();

        $faker = \Faker\Factory::create();

        for($i = 0; $i < 20; $i++) {

        	WeightHistory::create([
        		'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        		'weight' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
        		'dog_id' => $faker->numberBetween($min = 1, $max = 20),
        	]);
        }
    }
}
