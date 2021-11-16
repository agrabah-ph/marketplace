<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReverseBiddingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * name
        quantity
        days
        duration
        asking_price
        buying_price
         */
        Schema::table('reverse_biddings', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->float('quantity', 12,2)->nullable()->change();
            $table->string('duration')->nullable()->change();
            $table->float('asking_price',12,2)->nullable()->change();
            $table->string('unit_of_measure')->nullable()->change();

            $table->dateTime('delivery_date_time')->nullable()->after('delivery_address');
            $table->integer('category_id')->after('po_num');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reverse_biddings', function (Blueprint $table) {
            $table->dropColumn('delivery_date_time');
            $table->dropColumn('category_id');
        });
    }
}
