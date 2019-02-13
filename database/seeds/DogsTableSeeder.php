<?php

use Illuminate\Database\Seeder;

use App\Models\Dog;
class DogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	//Dog::truncate();

        $faker = \Faker\Factory::create();

        //iteration to create 10 fake records
        for ($i = 0; $i < 20; $i++) {
        	Dog::create([
        		'name' => $faker->name,
        		'breed_id' => $faker->numberBetween($min = 1, $max = 20),
        		'gender' => TRUE,
        		'picture' => $faker->imageUrl($width = 400, $height = 400, 'cats'),
        		'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
        		'color_id' => $faker->numberBetween($min = 1, $max = 15),
        		'size_id' => $faker->numberBetween($min = 1, $max = 5),
        		'weight' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 50),
                'sterialized' => FALSE,
                'last_zeal' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'special_care' => FALSE,
                'desc_special_Care' => $faker->text,
                'status' => TRUE,
                'lunch_time' => $faker->time($format = 'H:i', $max = 'now'),
                'friendly' => TRUE,
                'observations' => $faker->text,
                'user_id' => $faker->numberBetween($min = 1, $max = 10),
        	]);
        }
    }
}
