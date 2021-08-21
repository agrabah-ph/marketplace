<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class LoanProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create();
        $accounts = 100;
        for($a = 0; $a < $accounts; $a++) {
            $provider = \App\LoanProvider::count();
            $provider_id = rand(1,$provider);
            $type = \App\LoanType::count();
            $type_id = rand(1,$type);
            $provider_product_count = \App\LoanProduct::where('loan_provider_id', $provider_id)
                    ->where('loan_type_id', $type_id)
                    ->count() + 1;

            $loan = new \App\LoanProduct();
            $loan->loan_provider_id = $provider_id;
            $loan->loan_type_id = $type_id;
            $loan->name = "Loan Product ".$provider_product_count;
            $loan->description = $faker->word(rand(1,20));
            $loan->amount = rand(1,9) * 10000;
            $loan->duration = rand(5,30);
            $loan->interest_rate = rand(1,100);
            $loan->save();
        }
    }
}
