<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traces', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->string('code')->nullable();
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('delivered')->default(0);
            $table->integer('user_id');
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
        Schema::dropIfExists('traces');
    }
}
