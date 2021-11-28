<?php

namespace Tests\Feature;

use App\Farmer;
use App\LoanProvider;
use App\MarketPlace;
use App\MarketplaceCart;
use App\MarketplaceOrder;
use App\Profile;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Tests\TestCase;

class MarketplaceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMarketplaceAddItem()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 1;
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

        $response = $this->get('market-place/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $marketplaceStoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $marketplaceStoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
            ];
        $response = $this->post(route('market-place.store'), $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('market-place.index'));

        $added_market_place = MarketPlace::where('name', $marketplaceStoreName)->first();

        $response = $this->get('market-place/'.$added_market_place->id.'/edit');
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
    public function testMarketplaceViewItem()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 1;
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

        $response = $this->get('market-place/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $marketplaceStoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $marketplaceStoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('market-place.store'), $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('market-place.index'));

        $added_market_place = MarketPlace::where('name', $marketplaceStoreName)->first();

        $response = $this->get('market-place/'.$added_market_place->id.'/edit');
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
    public function testMarketplaceEditItem()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 1;
        $farmer->save();

//        try {
//            QrCode::size(500)
//                ->format('png')
//                ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));
//        }catch(\Exception $e){
//            dump($e);
//        }

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

        $response = $this->get('market-place/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $marketplaceStoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $marketplaceStoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('market-place.store'), $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('market-place.index'));

        $added_market_place = MarketPlace::where('name', $marketplaceStoreName)->first();

        $response = $this->get('market-place/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "name"=> $marketplaceStoreName.'1',
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('market-place/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('market-place/'.$added_market_place->id.'/edit');

        DB::rollBack();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMarketplaceListing()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 1;
        $farmer->save();

//        try {
//            QrCode::size(500)
//                ->format('png')
//                ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));
//        }catch(\Exception $e){
//            dump($e);
//        }

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

        $response = $this->get('market-place/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $marketplaceStoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $marketplaceStoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('market-place.store'), $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('market-place.index'));

        $added_market_place = MarketPlace::where('name', $marketplaceStoreName)->first();

        $response = $this->get('market-place/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "name"=> $marketplaceStoreName.'1',
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('market-place/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('market-place/'.$added_market_place->id.'/edit');


        //listing


        $response = $this->get('market-place-listing');
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
    public function testMarketplaceAddToCart()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 1;
        $farmer->save();

//        try {
//            QrCode::size(500)
//                ->format('png')
//                ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));
//        }catch(\Exception $e){
//            dump($e);
//        }

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

        $response = $this->get('market-place/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $marketplaceStoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $marketplaceStoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('market-place.store'), $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('market-place.index'));

        $added_market_place = MarketPlace::where('name', $marketplaceStoreName)->first();

        $response = $this->get('market-place/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "name"=> $marketplaceStoreName.'1',
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('market-place/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('market-place/'.$added_market_place->id.'/edit');


        //listing


        $response = $this->get('market-place-listing');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post(route('market-place-add_cart'), ['id' => $added_market_place->id]);
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
    public function testMarketplaceCart()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 1;
        $farmer->save();

//        try {
//            QrCode::size(500)
//                ->format('png')
//                ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));
//        }catch(\Exception $e){
//            dump($e);
//        }

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

        $response = $this->get('market-place/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $marketplaceStoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $marketplaceStoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('market-place.store'), $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('market-place.index'));

        $added_market_place = MarketPlace::where('name', $marketplaceStoreName)->first();

        $response = $this->get('market-place/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "name"=> $marketplaceStoreName.'1',
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('market-place/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('market-place/'.$added_market_place->id.'/edit');


        //listing


        $response = $this->get('market-place-listing');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post(route('market-place-add_cart'), ['id' => $added_market_place->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $response = $this->get('market-place-cart');
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
    public function testMarketplaceLockingOrder()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 1;
        $farmer->save();

//        try {
//            QrCode::size(500)
//                ->format('png')
//                ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));
//        }catch(\Exception $e){
//            dump($e);
//        }

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

        $response = $this->get('market-place/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $marketplaceStoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $marketplaceStoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('market-place.store'), $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('market-place.index'));

        $added_market_place = MarketPlace::where('name', $marketplaceStoreName)->first();

        $response = $this->get('market-place/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "name"=> $marketplaceStoreName.'1',
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('market-place/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('market-place/'.$added_market_place->id.'/edit');


        //listing


        $response = $this->get('market-place-listing');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post(route('market-place-add_cart'), ['id' => $added_market_place->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $response = $this->get('market-place-cart');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $lastInsertMarketPlace = MarketPlace::latest()->first();
        $lastInsertMarketPlaceCart = MarketplaceCart::latest()->first();
        $response = $this->post(route('market-place-lock_in_order'), ['form'=> '[{"id":'.$lastInsertMarketPlace->id.',"cart_id":'.$lastInsertMarketPlaceCart->id.',"price":4211,"qty":1,"sub_total":4211}]']);
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
    public function testMarketplaceOrderApproving()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 1;
        $farmer->save();

//        try {
//            QrCode::size(500)
//                ->format('png')
//                ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));
//        }catch(\Exception $e){
//            dump($e);
//        }

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

        $response = $this->get('market-place/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $marketplaceStoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $marketplaceStoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('market-place.store'), $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('market-place.index'));

        $added_market_place = MarketPlace::where('name', $marketplaceStoreName)->first();

        $response = $this->get('market-place/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "name"=> $marketplaceStoreName.'1',
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('market-place/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('market-place/'.$added_market_place->id.'/edit');


        //listing


        $response = $this->get('market-place-listing');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post(route('market-place-add_cart'), ['id' => $added_market_place->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $response = $this->get('market-place-cart');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $lastInsertMarketPlace = MarketPlace::latest()->first();
        $lastInsertMarketPlaceCart = MarketplaceCart::latest()->first();
        $response = $this->post(route('market-place-lock_in_order'), ['form'=> '[{"id":'.$lastInsertMarketPlace->id.',"cart_id":'.$lastInsertMarketPlaceCart->id.',"price":4211,"qty":1,"sub_total":4211}]']);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $lastInsertMarketPlaceOrder = MarketplaceOrder::latest()->first();
        $response = $this->post('market-place-approve', ['id'=>$lastInsertMarketPlaceOrder->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);

        DB::rollBack();

    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMarketplaceOrderDeliver()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 1;
        $farmer->save();

//        try {
//            QrCode::size(500)
//                ->format('png')
//                ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));
//        }catch(\Exception $e){
//            dump($e);
//        }

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

        $response = $this->get('market-place/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $marketplaceStoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $marketplaceStoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('market-place.store'), $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('market-place.index'));

        $added_market_place = MarketPlace::where('name', $marketplaceStoreName)->first();

        $response = $this->get('market-place/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "name"=> $marketplaceStoreName.'1',
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('market-place/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('market-place/'.$added_market_place->id.'/edit');


        //listing


        $response = $this->get('market-place-listing');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post(route('market-place-add_cart'), ['id' => $added_market_place->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $response = $this->get('market-place-cart');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $lastInsertMarketPlace = MarketPlace::latest()->first();
        $lastInsertMarketPlaceCart = MarketplaceCart::latest()->first();
        $response = $this->post(route('market-place-lock_in_order'), ['form'=> '[{"id":'.$lastInsertMarketPlace->id.',"cart_id":'.$lastInsertMarketPlaceCart->id.',"price":4211,"qty":1,"sub_total":4211}]']);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $lastInsertMarketPlaceOrder = MarketplaceOrder::latest()->first();
        $response = $this->post('market-place-approve', ['id'=>$lastInsertMarketPlaceOrder->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);

        $response = $this->post('market-place-deliver', ['id'=>$lastInsertMarketPlaceOrder->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);

        DB::rollBack();

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMarketplaceOrderDelivered()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('farmer'));
        $user->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $user->id;
        $farmer->url = 'http://agrabah-marketplace.test/farmer/1';
        $farmer->community_leader = 1;
        $farmer->save();

//        try {
//            QrCode::size(500)
//                ->format('png')
//                ->generate($farmer->url, public_path('images/farmer/' . $farmer->account_id . '.png'));
//        }catch(\Exception $e){
//            dump($e);
//        }

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

        $response = $this->get('market-place/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $marketplaceStoreName = "unit_test_".now()->unix();
        $array = [
            "name"=> $marketplaceStoreName,
            "selling_price" => "100,000.00",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];
        $response = $this->post(route('market-place.store'), $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('market-place.index'));

        $added_market_place = MarketPlace::where('name', $marketplaceStoreName)->first();

        $response = $this->get('market-place/'.$added_market_place->id.'/edit');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "name"=> $marketplaceStoreName.'1',
            "_method" => "PUT",
            "selling_price" => "999",
            "from_user_id"=> "5",
            "area"=> "125",
            "quantity"=> "125",
            "unit_of_measure"=> "kilos",
        ];

        $response = $this->post('market-place/'. $added_market_place->id, $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('market-place/'.$added_market_place->id.'/edit');


        //listing


        $response = $this->get('market-place-listing');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post(route('market-place-add_cart'), ['id' => $added_market_place->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $response = $this->get('market-place-cart');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $lastInsertMarketPlace = MarketPlace::latest()->first();
        $lastInsertMarketPlaceCart = MarketplaceCart::latest()->first();
        $response = $this->post(route('market-place-lock_in_order'), ['form'=> '[{"id":'.$lastInsertMarketPlace->id.',"cart_id":'.$lastInsertMarketPlaceCart->id.',"price":4211,"qty":1,"sub_total":4211}]']);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $lastInsertMarketPlaceOrder = MarketplaceOrder::latest()->first();
        $response = $this->post('market-place-approve', ['id'=>$lastInsertMarketPlaceOrder->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);

        $response = $this->post('market-place-deliver', ['id'=>$lastInsertMarketPlaceOrder->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);


        $response = $this->post('market-place-delivered', ['id'=>$lastInsertMarketPlaceOrder->id]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);


        DB::rollBack();

    }

}
