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

Route::post('wharf-user-registration-store', 'PublicController@wharfUserRegistrationStore')->name('wharf-user-registration-store');
Route::post('user-profile-store', 'ProfileController@profileStore')->name('user-profile-store');
Route::post('profile/store', 'FarmerController@profileStore')->name('profile-store');
Route::get('profile/create', 'PublicController@farmerProfileCreate')->name('profile-create');

Route::view('email/wharf/notification', 'emails/wharf/notification');

Route::middleware(['auth', 'verified', 'has_profile'])->group(function () {
    Route::get('bfar/trace', 'BfarController@traceIndex')->name('trace-bfar');
    Route::get('bfar/trace/{id}', 'BfarController@traceShow')->name('trace-bfar-show');
});

Route::middleware(['auth', 'verified', 'has_profile'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('profile', 'ProfileController')->except(['create','store']);
    Route::resource('farmer', 'FarmerController');


    Route::get('my-profile', 'ProfileController@myProfile')->name('my-profile');
    Route::get('edit-profile', 'ProfileController@editProfile')->name('edit-profile');
    Route::post('profile-update', 'ProfileController@updateProfile')->name('profile-update');
    Route::get('select-profile', 'ProfileController@selectProfile')->name('select-profile');
    Route::get('get-my-profile', 'ProfileController@getMyProfile')->name('get-my-profile');

    Route::resource('market-place', 'MarketPlaceController');
    Route::post('market-place-post-bid', 'MarketPlaceController@postBid')->name('market-place.post_bid');
    Route::post('market-place-refresh-bid', 'MarketPlaceController@refreshBid')->name('market-place.refresh_bid');


    Route::get('market-place-listing', 'MarketPlaceCartingController@index')->name('market-place-listing');
    Route::get('market-place-cart', 'MarketPlaceCartingController@cart')->name('market-place-cart');
    Route::get('market-place-my-orders', 'MarketPlaceCartingController@myOrders')->name('market-place-my_orders');
    Route::get('market-place-show/{id}', 'MarketPlaceCartingController@show')->name('market-place-show');
    Route::post('market-place-add-to-cart', 'MarketPlaceCartingController@addToCart')->name('market-place-add_cart');
    Route::post('market-place-lock-in-order', 'MarketPlaceCartingController@lockInOrder')->name('market-place-lock_in_order');
    Route::post('market-place-verify-payment', 'MarketPlaceCartingController@verifyPayment')->name('market-place-verify_payment');
    Route::post('market-place-remove-item', 'MarketPlaceCartingController@removeItem')->name('market-place-remove_item');
    Route::post('market-place-deliver', 'MarketPlaceCartingController@deliver')->name('market-place-deliver');
    Route::post('market-place-delivered', 'MarketPlaceCartingController@delivered')->name('market-place-delivered');
    Route::post('market-place-inventory-actions', 'MarketPlaceCartingController@inventoryActions')->name('market-place-inventory-actions');
    Route::get('market-place-orders', 'MarketPlaceCartingController@orders')->name('market-place-orders');

    Route::get('market-place-my-bids', 'MarketPlaceController@myBids')->name('market-place.my_bids');
    Route::post('market-place-make-winner', 'MarketPlaceController@makeWinner')->name('market-place.make_winner');
    Route::get('market-place-winning-bids', 'MarketPlaceController@winningBids')->name('market-place.winning_bids');
    Route::post('market-place-complete-bid', 'MarketPlaceController@completeBid')->name('market-place.complete_bid');

    Route::resource('purchase-order', 'PurchaseOrderController');
    Route::resource('spot-market', 'SpotMarketController');
    Route::get('spot-market-cart', 'SpotMarketController@cart')->name('spot-market.cart');
    Route::get('spot-market-my-orders', 'SpotMarketController@myOrders')->name('spot-market.my_orders');
    Route::post('spot-market-add-to-cart', 'SpotMarketController@addToCart')->name('spot-market.add_cart');
    Route::post('spot-market-lock-in-order', 'SpotMarketController@lockInOrder')->name('spot-market.lock_in_order');
    Route::post('spot-market-verify-payment', 'SpotMarketController@verifyPayment')->name('spot-market.verify_payment');

    Route::post('spot-market-post-bid', 'SpotMarketController@postBid')->name('spot-market.post_bid');
    Route::post('spot-market-refresh-bid', 'SpotMarketController@refreshBid')->name('spot-market.refresh_bid');

    Route::get('my-bids', 'SpotMarketController@myBids')->name('spot-market.my_bids');
    Route::post('spot-market-make-winner', 'SpotMarketController@makeWinner')->name('spot-market.make_winner');
    Route::get('winning-bids', 'SpotMarketController@winningBids')->name('spot-market.winning_bids');
    Route::post('spot-market-complete-bid', 'SpotMarketController@completeBid')->name('spot-market.complete_bid');

    Route::resource('reverse-bidding', 'ReverseBiddingController');


    Route::post('reverse-bidding-post-bid', 'ReverseBiddingController@postBid')->name('reverse-bidding.post_bid');
    Route::post('reverse-bidding-refresh-bid', 'ReverseBiddingController@refreshBid')->name('reverse-bidding.refresh_bid');

    Route::get('reverse-bidding-my-bids', 'ReverseBiddingController@myBids')->name('reverse-bidding.my_bids');
    Route::post('reverse-bidding-make-winner', 'ReverseBiddingController@makeWinner')->name('reverse-bidding.make_winner');
    Route::get('reverse-bidding-winning-bids', 'ReverseBiddingController@winningBids')->name('reverse-bidding.winning_bids');
    Route::post('reverse-bidding-complete-bid', 'ReverseBiddingController@completeBid')->name('reverse-bidding.complete_bid');


    Route::resource('report', 'ReportController');
});




