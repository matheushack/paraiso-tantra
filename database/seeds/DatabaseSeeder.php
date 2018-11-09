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
         $this->call(UsersSeeder::class);
         $this->call(BanksSeeder::class);
         $this->call(CustomersSeeder::class);
         $this->call(UnitsSeeder::class);
         $this->call(EmployeesSeeder::class);
         $this->call(RoomsSeeder::class);
         $this->call(ServicesSeeder::class);
    }
}
