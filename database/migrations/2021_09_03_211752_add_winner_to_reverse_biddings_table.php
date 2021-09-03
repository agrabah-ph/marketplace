<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWinnerToReverseBiddingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reverse_bidding_bids', function (Blueprint $table) {
            $table->boolean('winner')->after('bid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reverse_bidding_bids', function (Blueprint $table) {
            $table->dropColumn('winner');
        });
    }
}
