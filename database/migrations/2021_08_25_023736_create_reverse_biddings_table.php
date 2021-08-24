<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReverseBiddingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reverse_biddings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->text('description');
            $table->double('quantity', 12,2);
            $table->string('duration');
            $table->dateTime('expiration_time')->nullable();;
            $table->double('asking_price',12,2);
            $table->double('buying_price',12,2)->nullable();
            $table->string('area')->nullable();
            $table->string('method')->nullable();
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
        Schema::dropIfExists('reverse_biddings');
    }
}
