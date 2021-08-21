<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('model_id')->nullable();
            $table->string('model_type')->nullable();
            $table->string('type')->nullable();
            $table->string('value_0')->nullable();
            $table->string('value_1')->nullable();
            $table->string('value_2')->nullable();
            $table->string('value_3')->nullable();
            $table->string('value_4')->nullable();
            $table->string('value_5')->nullable();
            $table->string('value_6')->nullable();
            $table->string('value_7')->nullable();
            $table->string('value_8')->nullable();
            $table->string('value_9')->nullable();
            $table->integer('int_0')->nullable();
            $table->integer('int_1')->nullable();
            $table->integer('int_2')->nullable();
            $table->integer('int_3')->nullable();
            $table->integer('int_4')->nullable();
            $table->integer('int_5')->nullable();
            $table->text('text_0')->nullable();
            $table->text('text_1')->nullable();
            $table->text('text_2')->nullable();
            $table->text('text_3')->nullable();
            $table->text('text_4')->nullable();
            $table->text('text_5')->nullable();
            $table->date('date_0')->nullable();
            $table->date('date_1')->nullable();
            $table->date('date_2')->nullable();
            $table->date('date_3')->nullable();
            $table->date('date_4')->nullable();
            $table->date('date_5')->nullable();
            $table->boolean('switch_0')->default(0);
            $table->boolean('switch_1')->default(0);
            $table->boolean('switch_2')->default(0);
            $table->boolean('switch_3')->default(0);
            $table->boolean('switch_4')->default(0);
            $table->boolean('switch_5')->default(0);
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
        Schema::dropIfExists('model_infos');
    }
}
