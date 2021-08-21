<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// GLOBAL ROUTES START
Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin-generate-permissions', function () {
    echo "Generating Spot Market Permission<br>";
    Artisan::call('permission:spot_market');
    return 'Done';
});

Route::get('/registration', 'Controller@registration');

Route::get('qr-reader', 'PublicController@qrReader')->name('qr-reader');
Route::get('sms-test', 'PublicController@smsTest')->name('sms-test');
Route::get('test', 'PublicController@test')->name('test');


//Auth::routes();
Auth::routes(['verify' => true]);
Route::get('logout', 'UserController@logout')->name('logout');

Route::domain('admin'.config('dev.domain_ext'))->group(function () {

    Route::middleware(['auth', 'verified', 'has_profile'])->group(function () {

        Route::get('/home', 'HomeController@index')->name('home');

        Route::get('activation', 'PublicController@activation')->name('activation');

        Route::resource('farmer', 'FarmerController');
        Route::resource('community-leader', 'CommunityLeaderController');
        Route::resource('loan-provider', 'LoanProviderController');

        Route::resource('profile', 'ProfileController');
        Route::get('my-profile', 'ProfileController@myProfile')->name('my-profile');
        Route::get('select-profile', 'ProfileController@selectProfile')->name('select-profile');
        Route::get('get-my-profile', 'ProfileController@getMyProfile')->name('get-my-profile');

        Route::resource('product', 'ProductController');
        Route::get('product-list', 'ProductController@productList')->name('product-list');
        Route::get('product-unit-list', 'ProductController@productUnitList')->name('product-unit-list');
        Route::post('product-store', 'ProductController@productStore')->name('product-store');

        Route::resource('user', 'UserController');
        // Route::get('user-list', 'UserController@userList')->name('user-list');
        Route::get('user-list', 'UserController@userList')->name('user-list');
        Route::get('personnel-info', 'UserController@personnelInfo')->name('personnel-info');
        Route::post('create-user', 'UserController@createUser')->name('create-user');

        Route::get('role', 'RoleController@index')->name('role');
        Route::get('role-show/{id}', 'RoleController@show')->name('role-show');
        Route::post('role-update/{id}', 'RoleController@update')->name('role-update');
        Route::post('add-role', 'RoleController@addRole')->name('add-role');

        Route::post('save_registrant', 'RoleController@saveRegistrant')->name('save-registrant');

        Route::resource('settings', 'SettingController');

        Route::get('trace-report', 'ReportController@traceReport')->name('trace-report');
        Route::get('trace-table-report', 'ReportController@traceTableReport')->name('trace-table-report');

        Route::post('print-report', 'ReportController@printReport')->name('print-report');
        Route::post('print-report-data', 'ReportController@printReportData')->name('print-report-data');

        Route::get('loan/proof/{id}/{filename}', 'LoanController@proofPhoto')->name('loan-proof');
        Route::get('loan/applicants', 'LoanProviderController@loanApplicant')->name('loan-applicant');


        Route::resource('inventory', 'InventoryController');
        Route::resource('trace', 'Trace\TraceController');
    });
});
// GLOBAL ROUTES END

Route::domain(config('dev.domain_ext'))->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('wharf-user-registration-store', 'PublicController@wharfUserRegistrationStore')->name('wharf-user-registration-store');
    Route::get('profile/create', 'PublicController@farmerProfileCreate')->name('profile-create');
    Route::post('profile/store', 'FarmerController@profileStore')->name('profile-store');
    Route::post('user-profile-store', 'ProfileController@profileStore')->name('user-profile-store');


    Route::middleware(['auth', 'verified', 'has_profile'])->group(function () {
        Route::resource('purchase-order', 'PurchaseOrderController');
        Route::resource('spot-market', 'SpotMarketController');
        Route::get('spot-market-cart', 'SpotMarketController@cart')->name('spot-market.cart');
        Route::get('spot-market-my-orders', 'SpotMarketController@myOrders')->name('spot-market.my_orders');
        Route::post('spot-market-add-to-cart', 'SpotMarketController@addToCart')->name('spot-market.add_cart');
        Route::post('spot-market-lock-in-order', 'SpotMarketController@lockInOrder')->name('spot-market.lock_in_order');
        Route::post('spot-market-verify-payment', 'SpotMarketController@verifyPayment')->name('spot-market.verify_payment');

        Route::post('spot-market-post-bid', 'SpotMarketController@postBid')->name('spot-market.post_bid');
        Route::post('spot-market-refresh-bid', 'SpotMarketController@refreshBid')->name('spot-market.refresh_bid');

        Route::get('spot-market-my-bids', 'SpotMarketController@myBids')->name('spot-market.my_bids');
        Route::post('spot-market-make-winner', 'SpotMarketController@makeWinner')->name('spot-market.make_winner');
        Route::get('spot-market-winning-bids', 'SpotMarketController@winningBids')->name('spot-market.winning_bids');
        Route::post('spot-market-complete-bid', 'SpotMarketController@completeBid')->name('spot-market.complete_bid');
    });
});




