<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBfarNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * 1. Starting point of travel
           2. Product - how many kg /banyera
           4. Destination
           5. Community leader
           6. Date of travel
           7. Type of vehicle
         */
        Schema::create('bfar_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('from')->nullable();
            $table->string('product')->nullable();
            $table->double('quantity')->nullable();
            $table->string('unit_of_measure')->nullable();
            $table->string('destination')->nullable();
            $table->integer('com_leader_user_id')->nullable();
            $table->date('date_of_travel')->nullable();
            $table->string('type_of_vehicle')->nullable();
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
        Schema::dropIfExists('bfar_notifications');
    }
}
