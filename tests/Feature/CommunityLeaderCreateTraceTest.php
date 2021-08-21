<?php

namespace Tests\Feature;

use App\CommunityLeader;
use App\Farmer;
use App\Product;
use App\Profile;
use App\Trace;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Tests\TestCase;

class CommunityLeaderCreateTraceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCommunityLeaderCreateTrace()
    {
        DB::beginTransaction();

        /**
         * Start of creating master farmer
         */
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();

        $masterFarmer = new Farmer();
        $masterFarmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $masterFarmer->user_id = $user->id;
        $masterFarmer->community_leader = 1;
        $masterFarmer->save();

        /**
         * Login
         */
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);

        $traceSubDomain = 'trace.' . url('/');
        $_SERVER['HTTP_HOST'] = $traceSubDomain;

        /**
         * Creating Farmer
         */
        $farmer = new Farmer();
        $farmer->account_id = $farmerAccountNumber = Str::random(6);
        $farmer->url = route('inv-listing', array('account' => $farmerAccountNumber));
        $farmer->save();
        QrCode::size(500)
            ->format('png')
            ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));

        $faker = Factory::create();

        $profile = new Profile();
        $profile->first_name = $faker->firstName;
        $profile->last_name = $faker->lastName;
        $profile->middle_name = $faker->lastName;
        $profile->mobile = $faker->phoneNumber;
        $profile->education = $faker->word(1);
        $profile->secondary_info = $faker->sentence;
        $profile->spouse_comaker_info = $faker->sentence;
        $profile->spouse_comaker_info = $faker->sentence;
        $profile->farming_info = $faker->sentence;
        $profile->employment_info = $faker->sentence;
        $profile->income_asset_info = $faker->sentence;
        $profile->qr_image = $farmer->account_id . '.png';
        $profile->qr_image_path = '/images/farmer/' . $farmer->account_id . '.png';
        $farmer->profile()->save($profile);


        /**
         * Start of adding to inventory from farmer
         */
        $createFarmer = [
            'farmer' => $farmerAccountNumber,
        ];
        $response = $this->post(route('farmer-login-form'), $createFarmer);
        $response->assertRedirect('/farmers-info/' . $farmerAccountNumber);
        $response = $this->get(url('/farmers-info/' . $farmerAccountNumber));
        $response->assertStatus(200);

        $randomProducts  = Product::inRandomOrder()
            ->limit(2)
            ->get();
        $productIds = [];
        foreach($randomProducts as $randomProduct){
            $inventoryArray = [
                "details" => [
                    0 => null,
                    1 => $farmer->id,
                    2 => $randomProduct->id,
                    3 => "High",
                    4 => "inch",
                    5 => rand(0, 199),
                    6 => rand(0, 199),
                    7 => rand(0, 199),
                    8 => $faker->sentence,
                ]
            ];
            $response = $this->post(route('inv-listing-store'), $inventoryArray);
            if($response->exception){
                dd($response->exception) ;
            }
            $responseArray = json_decode($response->getContent());
            $productIds[] = $responseArray->id;
            $response->assertStatus(200);
        }

        /**
         * End of adding to inventory
         */



        /**
         * Start of creating Trace
         */
        $response = $this->get(route("trace.create"));
        $response->assertStatus(200);


        $code = Str::random(15);

        $url = route('trace-info', array('code' => $code));

        $traceArray = [
            "datas" => [
                0 => $faker->name,
                1 => $faker->email,
                2 => $faker->phoneNumber,
                3 => $faker->address,
                4 => $faker->name. "(Driver)",
                5 => $faker->phoneNumber. "(Driver)",
                6 => 'Van',
                7 => Str::random(6),
                8 => $code,
                9 => $url,
                10 => $productIds
            ]
        ];
        $response = $this->post(route('trace-store'), $traceArray);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        /**
         * End of creating Trace
         */



        /**
         * Navigating Trace
         */

        $response = $this->get($url);
        $response->assertStatus(200);
        $trace = Trace::where('reference', $code)->first();


        /**
         * Depart
         */
        $response = $this->get(route('trace-update-status')."?id=".$trace->id."&action=Depart");
        $response->assertStatus(200);


        /**
         * Transit
         */
        $response = $this->get(route('trace-update-status')."?id=".$trace->id."&action=Transit");
        $response->assertStatus(200);


        /**
         * Delivered
         */
        $response = $this->get(route('trace-shipped')."?code=".$trace->code);
        $response->assertStatus(200);



    }
}
