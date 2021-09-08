<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_places', function (Blueprint $table) {
            $table->id();
            $table->integer('model_id')->nullable();
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->text('name')->nullable();
            $table->double('quantity',12,2)->nullable();
            $table->string('duration')->nullable();
            $table->dateTime('expiration_time')->nullable();
            $table->longText('description')->nullable();
            $table->double('original_price')->nullable();
            $table->double('selling_price')->nullable();
            $table->string('area')->nullable();
            $table->string('method')->nullable();
            $table->string('unit_of_measure')->comment('kilos, bayeras, lot');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('market_places');
    }
}
