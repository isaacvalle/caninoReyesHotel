<?php

use Illuminate\Database\Seeder;

use App\Models\Room;
class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Room::truncate();

        $faker = \Faker\Factory::create();
        
        for ($i = 0; $i < 50; $i++) {
        	Room::create([
        		'number' => $i + 1,
        		'status' => true,
        		'description' => $faker->text,
        		'category_id' => $faker->numberBetween($min = 1, $max = 5)
        	]);
        }       
    }
}
