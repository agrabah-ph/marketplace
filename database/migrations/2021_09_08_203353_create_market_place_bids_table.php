<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketPlaceBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_place_bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('market_place_id');
            $table->unsignedBigInteger('user_id');
            $table->double('bid',12,2);
            $table->boolean('winner')->default(0);
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
        Schema::dropIfExists('market_place_bids');
    }
}
