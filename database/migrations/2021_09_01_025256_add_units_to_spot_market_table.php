<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitsToSpotMarketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spot_markets', function (Blueprint $table) {
            $table->string('unit_of_measure')->comment('kilos, bayeras, lot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spot_markets', function (Blueprint $table) {
            $table->dropColumn('unit_of_measure');
        });
    }
}
