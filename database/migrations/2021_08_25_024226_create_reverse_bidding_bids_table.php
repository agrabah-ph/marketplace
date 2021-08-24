<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReverseBiddingBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reverse_bidding_bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reverse_bidding_id');
            $table->unsignedBigInteger('user_id');
            $table->double('bid',12,2);
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
        Schema::dropIfExists('reverse_bidding_bids');
    }
}
