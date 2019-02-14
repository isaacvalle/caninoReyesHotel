<?php

use Illuminate\Database\Seeder;

use App\Models\SizeCategory;
class SizeCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SizeCategory::truncate();

        SizeCategory::create([
        	'name' => 'Mini',
        ]);

        SizeCategory::create([
        	'name' => 'Medium',
        ]);

        SizeCategory::create([
        	'name' => 'Normal',
        ]);

        SizeCategory::create([
        	'name' => 'Tall',
        ]);

        SizeCategory::create([
        	'name' => 'ExtraTall',
        ]);
    }
}
