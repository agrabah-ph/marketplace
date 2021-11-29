<?php

namespace Tests\Feature;

use App\BfarNotifications;
use App\Farmer;
use App\LoanProvider;
use App\MarketPlace;
use App\MarketplaceCart;
use App\MarketplaceOrder;
use App\Profile;
use App\ReverseBidding;
use App\ReverseBiddingBid;
use App\ReverseBiddingOffers;
use App\SpotMarket;
use App\SpotMarketBid;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Tests\TestCase;

class PurchaseOrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPurchaseOrderCreate()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $userClient = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userClient->assignRole(stringSlug('enterprise-client'));
        $userClient->markEmailAsVerified();

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
        $userClient->profile()->save($profile);


        $response = $this->post('/login', [
            'email' => $userClient->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userClient);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('reverse-bidding/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "po_num" => $StoreName,
            "category" => "5",
            "item_name" => [
                    "test 1",
                    "test 2"
                ],
            "item_quantity" => [
                    "1",
                    "32"
                ],
            "item_unit_of_measure" => [
                    "kilos",
                    "kilos"
                ],
            "area" => "Area11",
            "bid_end_date" => "11/18/2021",
            "bid_end_time" => "02:00",
            "delivery_address" => "152512512",
            "delivery_date" => "11/25/2021",
            "delivery_time" => "02:30",
            "description" => "LOREM IPSUM",
            "image" => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->post(route('reverse-bidding.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('reverse-bidding.index'));


        DB::rollBack();

    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPurchaseOrderView()
    {
        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $userClient = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userClient->assignRole(stringSlug('enterprise-client'));
        $userClient->markEmailAsVerified();

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
        $userClient->profile()->save($profile);


        $response = $this->post('/login', [
            'email' => $userClient->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userClient);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('reverse-bidding/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "po_num" => $StoreName,
            "category" => "5",
            "item_name" => [
                "test 1",
                "test 2"
            ],
            "item_quantity" => [
                "1",
                "32"
            ],
            "item_unit_of_measure" => [
                "kilos",
                "kilos"
            ],
            "area" => "Area11",
            "bid_end_date" => "11/18/2021",
            "bid_end_time" => "02:00",
            "delivery_address" => "152512512",
            "delivery_date" => "11/25/2021",
            "delivery_time" => "02:30",
            "description" => "LOREM IPSUM",
            "image" => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->post(route('reverse-bidding.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('reverse-bidding.index'));

        $added_po = ReverseBidding::where('po_num', $StoreName)->first();

        $response = $this->get('reverse-bidding/'.$added_po->id);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        DB::rollBack();

    }

    public function testPurchaseOrderListing()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $userClient = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userClient->assignRole(stringSlug('enterprise-client'));
        $userClient->markEmailAsVerified();

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
        $userClient->profile()->save($profile);


        $response = $this->post('/login', [
            'email' => $userClient->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userClient);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('reverse-bidding/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "po_num" => $StoreName,
            "category" => "5",
            "item_name" => [
                "test 1",
                "test 2"
            ],
            "item_quantity" => [
                "1",
                "32"
            ],
            "item_unit_of_measure" => [
                "kilos",
                "kilos"
            ],
            "area" => "Area11",
            "bid_end_date" => "11/18/2021",
            "bid_end_time" => "02:00",
            "delivery_address" => "152512512",
            "delivery_date" => "11/25/2021",
            "delivery_time" => "02:30",
            "description" => "LOREM IPSUM",
            "image" => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->post(route('reverse-bidding.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('reverse-bidding.index'));

        $added_po = ReverseBidding::where('po_num', $StoreName)->first();

        $response = $this->get('reverse-bidding/'.$added_po->id);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post('logout');

        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userFarmer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userFarmer->assignRole(stringSlug('farmer'));
        $userFarmer->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $userFarmer->id;
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

        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userFarmer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userFarmer);

        $response = $this->get('reverse-bidding');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        DB::rollBack();
    }

    public function testPurchaseOrderBidding()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $userClient = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userClient->assignRole(stringSlug('enterprise-client'));
        $userClient->markEmailAsVerified();

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
        $userClient->profile()->save($profile);


        $response = $this->post('/login', [
            'email' => $userClient->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userClient);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('reverse-bidding/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "po_num" => $StoreName,
            "category" => "5",
            "item_name" => [
                "test 1",
                "test 2"
            ],
            "item_quantity" => [
                "1",
                "32"
            ],
            "item_unit_of_measure" => [
                "kilos",
                "kilos"
            ],
            "area" => "Area11",
            "bid_end_date" => "11/18/2021",
            "bid_end_time" => "02:00",
            "delivery_address" => "152512512",
            "delivery_date" => "11/25/2021",
            "delivery_time" => "02:30",
            "description" => "LOREM IPSUM",
            "image" => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->post(route('reverse-bidding.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('reverse-bidding.index'));

        $added_po = ReverseBidding::where('po_num', $StoreName)->first();

        $response = $this->get('reverse-bidding/'.$added_po->id);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post('logout');

        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userFarmer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userFarmer->assignRole(stringSlug('farmer'));
        $userFarmer->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $userFarmer->id;
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

        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userFarmer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userFarmer);

        $response = $this->get('reverse-bidding');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->get('reverse-bidding/'.$added_po->id);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "item_id"=> [
                "10",
                "11"
            ],
            "item_price"=> [
                    "2",
                    "3"
                ],
            "item_cost"=> [
                    "2",
                    "96"
                ],
            "po_id"=> $added_po->id,
            "total_bid"=> "112.7",
            "vat"=> "11.76",
            "transaction_fee"=> "2.94",
            "gross_total"=> "98",
            "agree"=> [
                    "1",
                    "1"
                ]
        ];
    
       $response = $this->post('reverse-bidding-submit_offer', $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('reverse-bidding/'.$added_po->id);
        DB::rollBack();
    }

    public function testPurchaseOrderAwarding()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $userClient = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userClient->assignRole(stringSlug('enterprise-client'));
        $userClient->markEmailAsVerified();

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
        $userClient->profile()->save($profile);


        $response = $this->post('/login', [
            'email' => $userClient->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userClient);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('reverse-bidding/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "po_num" => $StoreName,
            "category" => "5",
            "item_name" => [
                "test 1",
                "test 2"
            ],
            "item_quantity" => [
                "1",
                "32"
            ],
            "item_unit_of_measure" => [
                "kilos",
                "kilos"
            ],
            "area" => "Area11",
            "bid_end_date" => "11/18/2021",
            "bid_end_time" => "02:00",
            "delivery_address" => "152512512",
            "delivery_date" => "11/25/2021",
            "delivery_time" => "02:30",
            "description" => "LOREM IPSUM",
            "image" => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->post(route('reverse-bidding.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('reverse-bidding.index'));

        $added_po = ReverseBidding::where('po_num', $StoreName)->first();

        $response = $this->get('reverse-bidding/'.$added_po->id);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post('logout');

        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userFarmer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userFarmer->assignRole(stringSlug('farmer'));
        $userFarmer->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $userFarmer->id;
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

        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userFarmer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userFarmer);

        $response = $this->get('reverse-bidding');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->get('reverse-bidding/'.$added_po->id);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "item_id"=> [
                "10",
                "11"
            ],
            "item_price"=> [
                    "2",
                    "3"
                ],
            "item_cost"=> [
                    "2",
                    "96"
                ],
            "po_id"=> $added_po->id,
            "total_bid"=> "112.7",
            "vat"=> "11.76",
            "transaction_fee"=> "2.94",
            "gross_total"=> "98",
            "agree"=> [
                    "1",
                    "1"
                ]
        ];

       $response = $this->post('reverse-bidding-submit_offer', $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('reverse-bidding/'.$added_po->id);

        //change expiration time
        $added_po->expiration_time = now()->subDay();
        $added_po->save();
        $this->isTrue($added_po->is_expired);

        //Awarding
        Artisan::call('spotmarket:award_winners');

        //checking if winner
        $this->isTrue($added_po->winner);
        $bid = ReverseBiddingOffers::where('reverse_bidding_id', $added_po->id)->where('user_id',$userFarmer->id)->first();
        $this->containsIdentical($bid->winner, 1);
        //end winning

        DB::rollBack();
    }

    public function testPurchaseOrderLocal()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $userClient = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userClient->assignRole(stringSlug('enterprise-client'));
        $userClient->markEmailAsVerified();

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
        $userClient->profile()->save($profile);


        $response = $this->post('/login', [
            'email' => $userClient->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userClient);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('reverse-bidding/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "po_num" => $StoreName,
            "category" => "5",
            "item_name" => [
                "test 1",
                "test 2"
            ],
            "item_quantity" => [
                "1",
                "32"
            ],
            "item_unit_of_measure" => [
                "kilos",
                "kilos"
            ],
            "area" => "Area11",
            "bid_end_date" => "11/18/2021",
            "bid_end_time" => "02:00",
            "delivery_address" => "152512512",
            "delivery_date" => "11/25/2021",
            "delivery_time" => "02:30",
            "description" => "LOREM IPSUM",
            "image" => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->post(route('reverse-bidding.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('reverse-bidding.index'));

        $added_po = ReverseBidding::where('po_num', $StoreName)->first();

        $response = $this->get('reverse-bidding/'.$added_po->id);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post('logout');

        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userFarmer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userFarmer->assignRole(stringSlug('farmer'));
        $userFarmer->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $userFarmer->id;
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

        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userFarmer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userFarmer);

        $response = $this->get('reverse-bidding');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->get('reverse-bidding/'.$added_po->id);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "item_id"=> [
                "10",
                "11"
            ],
            "item_price"=> [
                    "2",
                    "3"
                ],
            "item_cost"=> [
                    "2",
                    "96"
                ],
            "po_id"=> $added_po->id,
            "total_bid"=> "112.7",
            "vat"=> "11.76",
            "transaction_fee"=> "2.94",
            "gross_total"=> "98",
            "agree"=> [
                    "1",
                    "1"
                ]
        ];

       $response = $this->post('reverse-bidding-submit_offer', $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('reverse-bidding/'.$added_po->id);

        //change expiration time
        $added_po->expiration_time = now()->subDay();
        $added_po->save();
        $this->isTrue($added_po->is_expired);

        //Awarding
        Artisan::call('spotmarket:award_winners');

        //checking if winner
        $this->isTrue($added_po->winner);
        $bid = ReverseBiddingOffers::where('reverse_bidding_id', $added_po->id)->where('user_id',$userFarmer->id)->first();
        $this->containsIdentical($bid->winner, 1);
        //end winning

        $array = [
            "id"=> $added_po->id,
            "method" => "local",
        ];
        $response = $this->post('reverse-bidding-complete-bid/', $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);

        DB::rollBack();
    }

    public function testPurchaseOrderTransport()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider

        $userClient = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userClient->assignRole(stringSlug('enterprise-client'));
        $userClient->markEmailAsVerified();

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
        $userClient->profile()->save($profile);


        $response = $this->post('/login', [
            'email' => $userClient->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userClient);


        $_SERVER['HTTP_HOST'] = 'wharf.agrabah';

        $response = $this->get('reverse-bidding/create');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $StoreName = "unit_test_".now()->unix();
        $array = [
            "po_num" => $StoreName,
            "category" => "5",
            "item_name" => [
                "test 1",
                "test 2"
            ],
            "item_quantity" => [
                "1",
                "32"
            ],
            "item_unit_of_measure" => [
                "kilos",
                "kilos"
            ],
            "area" => "Area11",
            "bid_end_date" => "11/18/2021",
            "bid_end_time" => "02:00",
            "delivery_address" => "152512512",
            "delivery_date" => "11/25/2021",
            "delivery_time" => "02:30",
            "description" => "LOREM IPSUM",
            "image" => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->post(route('reverse-bidding.store'), $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect(route('reverse-bidding.index'));

        $added_po = ReverseBidding::where('po_num', $StoreName)->first();

        $response = $this->get('reverse-bidding/'.$added_po->id);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->post('logout');

        if($response->exception){
            dd($response->exception);
        }
        //listing


        $userFarmer = factory(User::class)->create(['password' => bcrypt($password = 'qwer1234'),]);
        $userFarmer->assignRole(stringSlug('farmer'));
        $userFarmer->markEmailAsVerified();


        $farmer = new Farmer();
        $farmer->account_id = $masterFarmerAccountNumber = Str::random(6);
        $farmer->user_id = $userFarmer->id;
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

        $response->assertRedirect('/');
        if($response->exception){
            dd($response->exception);
        }
        $response = $this->post('/login', [
            'email' => $userFarmer->email,
            'password' => $password,
        ]);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userFarmer);

        $response = $this->get('reverse-bidding');
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);

        $response = $this->get('reverse-bidding/'.$added_po->id);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(200);


        $array = [
            "item_id"=> [
                "10",
                "11"
            ],
            "item_price"=> [
                    "2",
                    "3"
                ],
            "item_cost"=> [
                    "2",
                    "96"
                ],
            "po_id"=> $added_po->id,
            "total_bid"=> "112.7",
            "vat"=> "11.76",
            "transaction_fee"=> "2.94",
            "gross_total"=> "98",
            "agree"=> [
                    "1",
                    "1"
                ]
        ];

       $response = $this->post('reverse-bidding-submit_offer', $array);

        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);
        $response->assertRedirect('reverse-bidding/'.$added_po->id);

        //change expiration time
        $added_po->expiration_time = now()->subDay();
        $added_po->save();
        $this->isTrue($added_po->is_expired);

        //Awarding
        Artisan::call('spotmarket:award_winners');

        //checking if winner
        $this->isTrue($added_po->winner);
        $bid = ReverseBiddingOffers::where('reverse_bidding_id', $added_po->id)->where('user_id',$userFarmer->id)->first();
        $this->containsIdentical($bid->winner, 1);
        //end winning


        $array = [
            "id"=> $added_po->id,
            "method" => "transport",
        ];

        $bfarNotificationCountFirst = BfarNotifications::count();

        $response = $this->post('reverse-bidding-complete-bid/', $array);
        if($response->exception){
            dd($response->exception);
        }
        $response->assertStatus(302);

        $bfarNotificationCountLast = BfarNotifications::count();

        $this->assertTrue($bfarNotificationCountFirst<$bfarNotificationCountLast);

        DB::rollBack();
    }


}
