<?php

namespace Tests\Feature;

use App\CommunityLeader;
use App\Farmer;
use App\Loan;
use App\LoanProduct;
use App\LoanProvider;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class LoanTest extends TestCase
{
//    use WithoutMiddleware; // use the trait
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoan()
    {

        DB::beginTransaction();

        $faker = Factory::create();
        //Register Loan Provider
        $createLoanProvider = [
            'type' => 'loan-provider',
            'email' => $faker->email,
            'password' => $faker->password,
            'repeat-password' => $faker->password,
        ];

        $response = $this->post(route('loan-user-registration-store'), $createLoanProvider);
        $response->assertRedirect('/');

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $user->assignRole(stringSlug('loan-provider'));
        $user->markEmailAsVerified();

        $loanProvider = new LoanProvider();
        $loanProvider->account_id = $masterFarmerAccountNumber = Str::random(6);
        $loanProvider->user_id = $user->id;
        $loanProvider->save();


        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);


        $completeLoanProviderProfile = [
            "first_name" => $loanProviderFname = $faker->firstName,
            "middle_name" => $faker->lastName,
            "last_name" => $loanProviderLname = $faker->lastName,
            "bank_name" => "bpi",
            "branch_name" => "albay",
            "address_line" => $faker->address,
            "account_name" => $loanProviderFname . ' '. $loanProviderLname,
            "account_number" => $faker->bankAccountNumber,
            "tin" => Str::random(6),
            "contact_person" => $loanProviderFname . ' '. $loanProviderLname,
            "contact_number" => $faker->phoneNumber,
            "designation" => $faker->jobTitle,
            "acceptTerms" => "on",
        ];
        $response = $this->post('/loan-provider/profile/store', $completeLoanProviderProfile);
        $response->assertRedirect('/home');

        $loanProductStore = [
            "name" => " test ",
            "type" => " 1 ",
            "description" => " 1244 ",
            "amount" => " 100.00 ",
            "duration" => " 2 ",
            "interest_rate" => " 10 ",
            "payment_schedule_input" => "[{ date : Aug 26, 2021 , amount : 55}, { date : Sep 26, 2021 , amount : 55}] ",
            "timing" => " monthly ",
            "allowance" => " 1 ",
            "first_allowance" => " 0 ",
            "disclosure" => $faker->paragraph,
        ];

        $response = $this->post(route('products.store'), $loanProductStore);
        $response->assertRedirect(route('products.index'));


        $this->get('logout');


        $userFarmer = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        $userFarmer->assignRole(stringSlug('farmer'));
        $userFarmer->markEmailAsVerified();

        $farmer = new Farmer();
        $farmer->account_id = $farmerAccountNumber = Str::random(6);
        $farmer->url = route('inv-listing', array('account' => $farmerAccountNumber));
        $farmer->user_id = $userFarmer->id;
        $farmer->save();


        $response = $this->post('/login', [
            'email' => $userFarmer->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userFarmer);

        $farmerProfile = [
            "forms" => [
                0 => [
                    0 => [
                        0 => "first_name",
                        1 => "First name",
                        2 => "John",
                    ],
                    1 => [
                        0 => "middle_name",
                        1 => "Middle name",
                        2 => "J",
                    ],
                    2 => [
                        0 => "last_name",
                        1 => "Last name",
                        2 => "Doe",
                    ],
                    3 => [
                        0 => "dob",
                        1 => "Date of Birth",
                        2 => "07/22/1993",
                    ],
                    4 => [
                        0 => "civil_status",
                        1 => "Civil Status",
                        2 => "Married",
                    ],
                    5 => [
                        0 => "gender",
                        1 => "Gender",
                        2 => "Male",
                    ],
                    6 => [
                        0 => "land-line",
                        1 => "Land Line",
                        2 => "5125125",
                    ],
                    7 => [
                        0 => "mobile",
                        1 => "Mobile",
                        2 => "5125151",
                    ],
                    8 => [
                        0 => "tin",
                        1 => "Tin No.",
                        2 => "12421",
                    ],
                    9 => [
                        0 => "sss_gsis",
                        1 => "SSS / GSIS No.",
                        2 => "125125",
                    ],
                    10 => [
                        0 => "education",
                        1 => "Education",
                        2 => "Post Graduate",
                    ],
                ],
                1 => [
                    0 => [
                        0 => "address_current",
                        1 => "Current Address",
                        2 => "124",
                    ],
                    1 => [
                        0 => "address_year_stay",
                        1 => "Years of Stay",
                        2 => "2151",
                    ],
                    2 => [
                        0 => "address_status",
                        1 => "Address Status",
                        2 => "Owned (Mortgaged)",
                    ],
                    3 => [
                        0 => "dependents",
                        1 => "Dependents",
                        2 => null,
                    ],
                ],
                2 => [
                    0 => [
                        0 => "spouse_first_name",
                        1 => "First name",
                        2 => "Earl Julius",
                    ],
                    1 => [
                        0 => "spouse_middle_name",
                        1 => "Middle name",
                        2 => "Macasinag",
                    ],
                    2 => [
                        0 => "spouse_last_name",
                        1 => "Last name",
                        2 => "Empic",
                    ],
                    3 => [
                        0 => "spouse_date_of_birth",
                        1 => "Date of Birth",
                        2 => "07/29/1993",
                    ],
                    4 => [
                        0 => "spouse_civil_status",
                        1 => "Civil Status",
                        2 => "Single",
                    ],
                    5 => [
                        0 => "spouse_gender",
                        1 => "Gender",
                        2 => "Male",
                    ],
                    6 => [
                        0 => "spouse_land_line",
                        1 => "Land Line",
                        2 => "124124",
                    ],
                    7 => [
                        0 => "spouse_mobile",
                        1 => "Mobile",
                        2 => "+639190967980",
                    ],
                    8 => [
                        0 => "spouse_tin",
                        1 => "Tin No.",
                        2 => "12515",
                    ],
                    9 => [
                        0 => "spouse_sss_gsis",
                        1 => "SSS / GSIS No.",
                        2 => "5125",
                    ],
                    10 => [
                        0 => "spouse_education",
                        1 => "Education",
                        2 => "High School",
                    ],
                ],
                3 => [
                    0 => [
                        0 => "farm_lot",
                        1 => "Farm Lot",
                        2 => "125",
                    ],
                    1 => [
                        0 => "farming_since",
                        1 => "Farming since",
                        2 => "125",
                    ],
                    2 => [
                        0 => "organization",
                        1 => "Organization",
                        2 => "21",
                    ],
                    3 => [
                        0 => "four_ps",
                        1 => "4P's",
                        2 => "1",
                    ],
                    4 => [
                        0 => "pwd",
                        1 => "PWD",
                        2 => "1",
                    ],
                    5 => [
                        0 => "indigenous",
                        1 => "Indigenous",
                        2 => "0",
                    ],
                    6 => [
                        0 => "livelihood",
                        1 => "Livelihood",
                        2 => "0",
                    ],
                ],
                4 => [
                    0 => [
                        0 => "employment",
                        1 => "Employment",
                        2 => [
                            0 => "Employed",
                            1 => [
                                0 => "employment_employed",
                                1 => "Type",
                                2 => "Private",
                            ],
                            2 => [
                                0 => "employed_position",
                                1 => "Position",
                                2 => "Professional",
                            ],
                            3 => [
                                0 => "employer_contact_number",
                                1 => "Tel No.",
                                2 => "51252",
                            ],
                            4 => [
                                0 => "employer_business_address",
                                1 => "Employer/Business Address",
                                2 => "512512512",
                            ],
                        ],
                    ],
                ],
                5 => [
                    0 => [
                        0 => "applicant_business_income",
                        1 => "Applicant Business Income",
                        2 => "10000",
                    ],
                    1 => [
                        0 => "applicant_employment_income",
                        1 => "Applicant Employment Income",
                        2 => "10000",
                    ],
                    2 => [
                        0 => "spouse_business_income",
                        1 => "Spouse Business Income",
                        2 => "10000",
                    ],
                    3 => [
                        0 => "spouse_employment_income",
                        1 => "Spouse Employment Income",
                        2 => "10000",
                    ],
                    4 => [
                        0 => "other_monthly_income",
                        1 => "Other Monthly Income",
                        2 => "10000",
                    ],
                    5 => [
                        0 => "monthly_expenses",
                        1 => "Less Monthly Expenses (Living, Utilitites, rental, transpo..)",
                        2 => "10000",
                    ],
                    6 => [
                        0 => "loan_amortization_expenses",
                        1 => "Loan Amortization (Mortgage/loan)",
                        2 => "10000"
                    ],
                    7 => [
                        0 => "assets",
                        1 => "Assets",
                        2 => null,
                    ]
                ]
            ]
        ];

        $response = $this->post('/user-profile-store', $farmerProfile);
        $response->assertStatus(200);
        $this->get('/home');

        $loanProduct = LoanProduct::where('loan_provider_id', $loanProvider->id)->first();
        $applyLoan = [
            "inputs" => [
                0 => $loanProduct->id,
                1 => [
                    0 => [
                        0 => "Purpose of Loan",
                        1 => [
                            0 => "Auto Financing",
                            1 => "Housing",
                        ],
                    ],
                    1 => [
                        0 => "Primary User",
                        1 => [
                            0 => "124",
                        ],
                    ],
                    2 => [
                        0 => "Relationship to Applicant",
                        1 => [
                            0 => "124",
                        ],
                    ],
                    3 => [
                        0 => "Place of use",
                        1 => [
                            0 => "Residential",
                            1 => "Residential / Commercial",
                        ],
                    ],
                    4 => [
                        0 => "Collateral",
                        1 => [
                            0 => "Land Title: TCT No.",
                            1 => [
                                0 => "Agracultural",
                            ],
                        ],
                    ],
                ],
                2 => [
                    0 => [
                        0 => "Bank Accounts",
                        1 => [
                            0 => [
                                0 => [
                                    0 => "Account type",
                                    1 => "Savings",
                                ],
                                1 => [
                                    0 => "Account No.",
                                    1 => "211255",
                                ],
                            ],
                        ],
                    ],
                    1 => [
                        0 => "Credit References",
                        1 => [
                            0 => [
                                0 => [
                                    0 => "Bank / Financing",
                                    1 => "1wqeqwe",
                                ],
                                1 => [
                                    0 => "Monthly Amortization",
                                    1 => "12412424",
                                ],
                            ],
                        ],
                    ],
                ],
                3 => [
                    0 => [
                        0 => "Trade and other reference",
                        1 => [
                            0 => [
                                0 => [
                                    0 => "Customer name / Co-maker",
                                    1 => "4124",
                                ],
                                1 => [
                                    0 => "Address",
                                    1 => "124124124",
                                ],
                                2 => [
                                    0 => "Contact No.",
                                    1 => "124124",
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $response = $this->post('/loan-submit-form', $applyLoan);
        $response->assertStatus(200);

        $application = $farmer->loans->first();
        //Test Admin decline
        $response = $this->get('/loan-update-status?id=' . $application->id . '&action=decline');
        $response->assertStatus(200);
        //Test Admin Accept
        $response = $this->get('/loan-update-status?id=' . $application->id . '&action=accept');
        $response->assertStatus(200);

        $this->assertEquals($application->status, 'Pending');

        $this->get('logout');

        //login as loan provider again
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/loan-update-status?id=' . $application->id . '&action=approve&amount=70%2C000.00&duration=7&interest_rate=91&timing=day&allowance=1&first_allowance=0&schedules%5B%5D=Jul%2029%2C%202021&schedules%5B%5D=Jul%2030%2C%202021&schedules%5B%5D=Jul%2031%2C%202021&schedules%5B%5D=Aug%201%2C%202021&schedules%5B%5D=Aug%202%2C%202021&schedules%5B%5D=Aug%203%2C%202021&schedules%5B%5D=Aug%204%2C%202021');
        $response->assertStatus(200);

        $application = Loan::find($application->id);
        $this->assertEquals($application->status, 'Active');
        $this->get('logout');

        //login as farmer again

        $response = $this->post('/login', [
            'email' => $userFarmer->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($userFarmer);

        $schedules = $application->payment_schedules;

        foreach($schedules as $schedule){
            $payment = [
                "loan_id" => $application->id,
                "payment_method" => "gcash",
                "paid_amount" => $schedule->payable_amount,
                "paid_date" => $faker->date(),
                "reference_number" => $faker->sentence,
                "proof_of_payment" => UploadedFile::fake()->image('avatar.jpg')
            ];
            $this->post('/verify-loan', $payment);
        }

        $this->assertGreaterThan(0, count($application->payments));

        $application = Loan::find($application->id);
        $this->assertEquals($application->status, 'Completed');

        DB::rollBack();
    }
}
