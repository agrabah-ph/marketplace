<?php

use Illuminate\Database\Seeder;

class LoanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array(
            'Short Loan',
            'Long Term Loan',
            'PO Financing',
            'Equipment Loan',
            'Crop Insurance',
            'Trade Insurance',
        );

        foreach($types as $type) {
            \App\LoanType::create(array(
                'name' => stringSlug($type),
                'display_name' => $type
            ));
        }
    }
}
