<?php

use Illuminate\Database\Seeder;

use App\Models\ZealHistory;
class ZealHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ZealHistory::truncate();

        $faker = \Faker\Factory::create();

        for($i = 0; $i < 20; $i++) {

        	ZealHistory::create([
        		'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        		'observations' => $faker->text,
        		'dog_id' => $faker->numberBetween($min = 1, $max = 20),
        	]);
        }
    }
}
