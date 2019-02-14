<?php

use Illuminate\Database\Seeder;

use App\Models\RoomCategory;
class RoomCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // RoomCategory::truncate();  

        RoomCategory::create([
        	'category' => 'xs',
        	'description' => 'to mini dogs'
        ]);

        RoomCategory::create([
        	'category' => 's',
        	'description' => 'to small dogs'
        ]);

        RoomCategory::create([
        	'category' => 'n',
        	'description' => 'to nomal dogs'
        ]);

        RoomCategory::create([
        	'category' => 't',
        	'description' => 'to tall dogs'
        ]);

        RoomCategory::create([
        	'category' => 'xt',
        	'description' => 'to extra tall dogs'
        ]);
    }
}
