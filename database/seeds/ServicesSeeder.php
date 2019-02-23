<?php

use Illuminate\Database\Seeder;

use App\Models\Service;
class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Service::truncate();

        Service::create([
        	'name' => 'hotel-xs',
        	'status' => true,
        	'description' => 'hotel service to mini dogs',
        	'price' => '120',
        	'discount' => '0'
        ]);

        Service::create([
        	'name' => 'daycare-xs',
        	'status' => true,
        	'description' => 'dog-daycare service to mini dogs',
        	'price' => '150',
        	'discount' => '0'
        ]);

        Service::create([
        	'name' => 'training-xs',
        	'status' => true,
        	'description' => 'training service to mini dogs',
        	'price' => '2000',
        	'discount' => '0'
        ]);

        Service::create([
        	'name' => 'veterinary-xs',
        	'status' => true,
        	'description' => 'veterinary service to mini dogs in our instalations',
        	'price' => '200',
        	'discount' => '0'
        ]);

        Service::create([
        	'name' => 'veterinary@home-xs',
        	'status' => true,
        	'description' => 'veterinary service to mini dogs at home',
        	'price' => '300',
        	'discount' => '0'
        ]);

        Service::create([
        	'name' => 'mortuary-xs',
        	'status' => true,
        	'description' => 'mortuary service to mini dogs',
        	'price' => '350',
        	'discount' => '0'
        ]);
    }
}
