<?php

namespace Tests\Feature;

use App\BfarNotifications;
use App\Farmer;
use App\LoanProvider;
use App\MarketPlace;
use App\MarketplaceCart;
use App\MarketplaceOrder;
use App\Profile;
use App\SpotMarket;
use App\SpotMarketBid;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Tests\TestCase;

class AuctionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAuctionAddItem()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 0;
        $farmer->save();

//        QrCode::size(500)
//            ->format('png')
//            ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));

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


        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('spot-market/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $StoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('spot-market.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('spot-market.index'));

        $added_market_place = SpotMarket::where('name', $StoreName)->first();


        $response = $this->get('spot-market/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        DB::rollBack();

    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAuctionViewItem()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 0;
        $farmer->save();

//        QrCode::size(500)
//            ->format('png')
//            ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));

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


        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('spot-market/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $StoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('spot-market.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('spot-market.index'));

        $added_market_place = SpotMarket::where('name', $StoreName)->first();


        $response = $this->get('spot-market/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        DB::rollBack();

    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAuctionEditItem()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 0;
        $farmer->save();

//        QrCode::size(500)
//            ->format('png')
//            ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));

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


        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('spot-market/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $StoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('spot-market.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('spot-market.index'));

        $added_market_place = SpotMarket::where('name', $StoreName)->first();


        $response = $this->get('spot-market/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $array = [
            "name"=> $StoreName.'1',
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('spot-market/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('spot-market/'.$added_market_place->id.'/edit');

        DB::rollBack();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAuctionListing()
    {


        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 0;
        $farmer->save();

//        QrCode::size(500)
//            ->format('png')
//            ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));

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


        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('spot-market/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $StoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('spot-market.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('spot-market.index'));

        $added_market_place = SpotMarket::where('name', $StoreName)->first();


        $response = $this->get('spot-market/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $array = [
            "name"=> $StoreName.'1',
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('spot-market/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('spot-market/'.$added_market_place->id.'/edit');

        $response = $this->post('logout');

        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userBuyer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userBuyer->assignRole(stringSlug('buyer'));
        $userBuyer->markEmailAsVerified();

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
        $userBuyer->profile()->save($profile);


        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userBuyer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userBuyer);

        $response = $this->get('spot-market');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        DB::rollBack();
    }

    public function testAuctionBidding()
    {


        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 0;
        $farmer->save();

//        QrCode::size(500)
//            ->format('png')
//            ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));

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


        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('spot-market/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $StoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('spot-market.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('spot-market.index'));

        $added_market_place = SpotMarket::where('name', $StoreName)->first();

        $response = $this->get('spot-market/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $array = [
            "name"=> $StoreName,
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('spot-market/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('spot-market/'.$added_market_place->id.'/edit');

        $response = $this->post('logout');

        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userBuyer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userBuyer->assignRole(stringSlug('buyer'));
        $userBuyer->markEmailAsVerified();

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
        $userBuyer->profile()->save($profile);


        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userBuyer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userBuyer);

        $response = $this->get('spot-market');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $current_bid = $added_market_place->current_bid;

        //bidding
        $array = [
            "id"=> $added_market_place->id,
            "value" => $current_bid+1,
        ];

        $response = $this->post('spot-market-post-bid/', $array);
        if($response->exception){
            dd($response->exception);
        }
        $jsonResponse = json_decode($response->getContent());
        $this->containsEqual($jsonResponse->status, true);
        $response->assertStatus(200);

        //end bidding

        DB::rollBack();
    }

    public function testAuctionWinningBid()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 0;
        $farmer->save();

//        QrCode::size(500)
//            ->format('png')
//            ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));

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


        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('spot-market/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $StoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('spot-market.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('spot-market.index'));

        $added_market_place = SpotMarket::where('name', $StoreName)->first();

        $response = $this->get('spot-market/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $array = [
            "name"=> $StoreName,
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('spot-market/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('spot-market/'.$added_market_place->id.'/edit');

        $response = $this->post('logout');

        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userBuyer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userBuyer->assignRole(stringSlug('buyer'));
        $userBuyer->markEmailAsVerified();

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
        $userBuyer->profile()->save($profile);


        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userBuyer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userBuyer);

        $response = $this->get('spot-market');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $current_bid = $added_market_place->current_bid;

        //bidding
        $array = [
            "id"=> $added_market_place->id,
            "value" => $current_bid+1,
        ];

        $response = $this->post('spot-market-post-bid/', $array);
        if($response->exception){
            dd($response->exception);
        }
        $jsonResponse = json_decode($response->getContent());
        $this->isTrue($jsonResponse->status);
        $response->assertStatus(200);

        //end bidding

        //change expiration time
        $added_market_place->expiration_time = now()->subDay();
        $added_market_place->save();
        $this->isTrue($added_market_place->is_expired);

        //Awarding
        Artisan::call('spotmarket:award_winners');

        //checking if winner
        $this->isTrue($added_market_place->winner);
        $bid = SpotMarketBid::where('spot_market_id', $added_market_place->id)->where('user_id',$userBuyer->id)->first();
        $this->containsIdentical($bid->winner, 1);
        //end winning

        DB::rollBack();
    }

    public function testAuctionCompletingBidLocal()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 0;
        $farmer->save();

//        QrCode::size(500)
//            ->format('png')
//            ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));

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


        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('spot-market/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $StoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('spot-market.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('spot-market.index'));

        $added_market_place = SpotMarket::where('name', $StoreName)->first();

        $response = $this->get('spot-market/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $array = [
            "name"=> $StoreName,
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('spot-market/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('spot-market/'.$added_market_place->id.'/edit');

        $response = $this->post('logout');
        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userBuyer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userBuyer->assignRole(stringSlug('buyer'));
        $userBuyer->markEmailAsVerified();

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
        $userBuyer->profile()->save($profile);


        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userBuyer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userBuyer);

        $response = $this->get('spot-market');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $current_bid = $added_market_place->current_bid;

        //bidding
        $array = [
            "id"=> $added_market_place->id,
            "value" => $current_bid+1,
        ];

        $response = $this->post('spot-market-post-bid/', $array);
        if($response->exception){
            dd($response->exception);
        }
        $jsonResponse = json_decode($response->getContent());
        $this->isTrue($jsonResponse->status);
        $response->assertStatus(200);

        //end bidding

        //change expiration time
        $added_market_place->expiration_time = now()->subDay();
        $added_market_place->save();
        $this->isTrue($added_market_place->is_expired);

        //Awarding
        Artisan::call('spotmarket:award_winners');

        //checking if winner
        $this->isTrue($added_market_place->winner);
        $bid = SpotMarketBid::where('spot_market_id', $added_market_place->id)->where('user_id',$userBuyer->id)->first();
        $this->containsIdentical($bid->winner, 1);
        //end winning


        //awarding
        $response = $this->post('logout');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);

        $response = $this->get('winning-bids');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        //spot-market-complete-bid
        //completing LOCAL

        $array = [
            "id"=> $added_market_place->id,
            "method" => "local",
        ];

        $response = $this->post('spot-market-complete-bid/', $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);

        DB::rollBack();
    }

    public function testAuctionCompletingBidTransport()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 0;
        $farmer->save();

//        QrCode::size(500)
//            ->format('png')
//            ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));

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


        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('spot-market/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $StoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('spot-market.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('spot-market.index'));

        $added_market_place = SpotMarket::where('name', $StoreName)->first();

        $response = $this->get('spot-market/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $array = [
            "name"=> $StoreName,
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('spot-market/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('spot-market/'.$added_market_place->id.'/edit');

        $response = $this->post('logout');
        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userBuyer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userBuyer->assignRole(stringSlug('buyer'));
        $userBuyer->markEmailAsVerified();

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
        $userBuyer->profile()->save($profile);


        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userBuyer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userBuyer);

        $response = $this->get('spot-market');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $current_bid = $added_market_place->current_bid;

        //bidding
        $array = [
            "id"=> $added_market_place->id,
            "value" => $current_bid+1,
        ];

        $response = $this->post('spot-market-post-bid/', $array);
        if($response->exception){
            dd($response->exception);
        }
        $jsonResponse = json_decode($response->getContent());
        $this->isTrue($jsonResponse->status);
        $response->assertStatus(200);

        //end bidding

        //change expiration time
        $added_market_place->expiration_time = now()->subDay();
        $added_market_place->save();
        $this->isTrue($added_market_place->is_expired);

        //Awarding
        Artisan::call('spotmarket:award_winners');

        //checking if winner
        $this->isTrue($added_market_place->winner);
        $bid = SpotMarketBid::where('spot_market_id', $added_market_place->id)->where('user_id',$userBuyer->id)->first();
        $this->containsIdentical($bid->winner, 1);
        //end winning


        //awarding
        $response = $this->post('logout');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);

        $response = $this->get('winning-bids');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        //spot-market-complete-bid
        //completing TRANSPORT

        $array = [
            "id"=> $added_market_place->id,
            "method" => "transport",
        ];

        $response = $this->post('spot-market-complete-bid/', $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);

        DB::rollBack();
    }

    public function testAuctionCheckBfarNotification()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 0;
        $farmer->save();

//        QrCode::size(500)
//            ->format('png')
//            ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));

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


        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('spot-market/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $StoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('spot-market.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('spot-market.index'));

        $added_market_place = SpotMarket::where('name', $StoreName)->first();

        $response = $this->get('spot-market/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $array = [
            "name"=> $StoreName,
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "duration"=> "00:05",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('spot-market/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('spot-market/'.$added_market_place->id.'/edit');

        $response = $this->post('logout');
        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userBuyer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userBuyer->assignRole(stringSlug('buyer'));
        $userBuyer->markEmailAsVerified();

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
        $userBuyer->profile()->save($profile);


        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userBuyer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userBuyer);

        $response = $this->get('spot-market');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $current_bid = $added_market_place->current_bid;

        //bidding
        $array = [
            "id"=> $added_market_place->id,
            "value" => $current_bid+1,
        ];

        $response = $this->post('spot-market-post-bid/', $array);
        if($response->exception){
            dd($response->exception);
        }
        $jsonResponse = json_decode($response->getContent());
        $this->isTrue($jsonResponse->status);
        $response->assertStatus(200);

        //end bidding

        //change expiration time
        $added_market_place->expiration_time = now()->subDay();
        $added_market_place->save();
        $this->isTrue($added_market_place->is_expired);

        //Awarding
        Artisan::call('spotmarket:award_winners');

        //checking if winner
        $this->isTrue($added_market_place->winner);
        $bid = SpotMarketBid::where('spot_market_id', $added_market_place->id)->where('user_id',$userBuyer->id)->first();
        $this->containsIdentical($bid->winner, 1);
        //end winning


        //awarding
        $response = $this->post('logout');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);

        $response = $this->get('winning-bids');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        //spot-market-complete-bid
        //completing TRANSPORT

        $array = [
            "id"=> $added_market_place->id,
            "method" => "transport",
        ];

        $bfarNotificationCountFirst = BfarNotifications::count();

        $response = $this->post('spot-market-complete-bid/', $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);

        $bfarNotificationCountLast = BfarNotifications::count();

        $this->assertTrue($bfarNotificationCountFirst<$bfarNotificationCountLast);

        DB::rollBack();
    }


}
