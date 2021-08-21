<?php

use Illuminate\Database\Seeder;
use App\LoanProvider;
use App\Profile;
use App\User;

class LoanProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = 5;
        for($a = 0; $a < $accounts; $a++){
            $faker = Faker\Factory::create();
            $number = str_pad(LoanProvider::count() + 1, 5, 0, STR_PAD_LEFT);
            $loanProvider = new LoanProvider();
            $loanProvider->account_id = $number;
            if($loanProvider->save()){
                $profile = new Profile();
                $profile->first_name = $faker->firstName;
                $profile->middle_name = $faker->lastName;
                $profile->last_name = $faker->lastName;
                $profile->designation = $faker->jobTitle;
                $profile->mobile = $faker->phoneNumber;
                $profile->landline = $faker->phoneNumber;
                $profile->bank_name = $faker->company;
                $profile->branch_name = $faker->country;
                $profile->branch_code = $faker->uuid;
                $profile->branch_address = $faker->address;
                $profile->contact_person = $faker->name;
                $profile->contact_number = $faker->phoneNumber;
                $profile->contact_designation = $faker->jobTitle;
                if($loanProvider->profile()->save($profile)){
                    $user = new User();
                    $user->name = ucwords($profile->first_name).' '.ucwords($profile->last_name);
                    $user->email = 'lp_'.($a+1).'@agrabah.ph';
                    $user->password = bcrypt('agrabah');
                    $user->passkey = 'agrabah';
                    $user->active = 1;
                    if($user->save()) {
                        $user->assignRole(stringSlug('Loan Provider'));
                        $user->markEmailAsVerified();
                        $loanProvider->user_id = $user->id;
                        $loanProvider->save();
                    }
                }
            }
        }
    }
}
