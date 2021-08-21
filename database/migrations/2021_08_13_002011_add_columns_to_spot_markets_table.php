<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSpotMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spot_markets', function (Blueprint $table) {
            $table->unsignedBigInteger('from_user_id')->after('model_type')->nullable();
            $table->string('duration')->after('name')->nullable();
            $table->double('quantity', 12,2)->after('name')->nullable();
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
            $table->dropColumn('from_user_id');
            $table->dropColumn('duration');
            $table->dropColumn('quantity');
        });
    }
}
