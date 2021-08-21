<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpotMarketReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spot_market_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spot_market_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('reviewer_name');
            $table->string('rating');
            $table->longText('comment');
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
        Schema::dropIfExists('spot_market_reviews');
    }
}
