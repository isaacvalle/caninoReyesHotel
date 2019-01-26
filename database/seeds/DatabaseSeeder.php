<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(LocalitiesTableSeeder::class);
        $this->call(MunicipalitiesTableSeeder::class);
        $this->call(StreetsTableSeeder::class);
        $this->call(StatesTableSeeder::class);

        $this->call(ZipCodesTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(ColorsTableSeeder::class);
        $this->call(SizeCategoriesTableSeeder::class);
        $this->call(BreedsTableSeeder::class); 

        $this->call(ReservationStatusesSeeder::class);
        $this->call(RoomCategoriesSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(ServicesSeeder::class);        
        $this->call(DogsTableSeeder::class);

        $this->call(WeightHistoriesTableSeeder::class);
        $this->call(ZealHistoriesTableSeeder::class);  
}
