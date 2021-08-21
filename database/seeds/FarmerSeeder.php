<?php

use Illuminate\Database\Seeder;
use App\Farmer;
use App\Profile;
use App\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = 10;
        for($a = 0; $a < $accounts; $a++){

            $faker = Faker\Factory::create();
//            $number = Farmer::count() + 1;
            $number = str_pad(Farmer::count() + 1, 5, 0, STR_PAD_LEFT);

            $farmer = new Farmer();
            $farmer->account_id = $number;
            if($farmer->save()){
                $user = new User();
                $user->email = $faker->email;
                $user->password = bcrypt('agrabah');
                $user->passkey = 'agrabah';
                $user->active = 1;
                if($user->save()) {
                    $user->assignRole(stringSlug('Farmer'));
                    $user->markEmailAsVerified();
                    $farmer->user_id = $user->id;
                    $farmer->save();
                }
            }
        }
    }
}
