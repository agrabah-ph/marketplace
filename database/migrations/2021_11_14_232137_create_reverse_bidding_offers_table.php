<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReverseBiddingOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reverse_bidding_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('reverse_bidding_id');
            $table->unsignedInteger('user_id');
            $table->boolean('winner')->default(0);
            $table->double('gross_total', 18, 4);
            $table->double('service_fee', 18, 4);
            $table->double('vat', 18, 4);
            $table->double('total_bid', 18, 4);
            $table->json('bids')->nullable();
            $table->dateTime('agree_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reverse_bidding_offers');
    }
}
