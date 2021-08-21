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
         $this->call(UserSeeder::class);
//         $this->call(FarmerSeeder::class);
//         $this->call(ProductSeeder::class);
         $this->call(LoanTypeSeeder::class);
//         $this->call(LoanProviderSeeder::class);
//         $this->call(LoanProductSeeder::class);
    }
}
