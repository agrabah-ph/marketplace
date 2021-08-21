<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('leader_id');
            $table->integer('farmer_id');
            $table->integer('product_id');
            $table->enum('quality', array('High', 'Medium', 'Low'));
            $table->integer('quantity');
            $table->string('unit');
            $table->double('price');
            $table->double('total');
            $table->text('details')->nullable();
            $table->enum('status', array('Accepted', 'Loaded', 'Depart', 'Transit', 'Arrive', 'Delivered', 'Undeliverable'));
            $table->string('remark')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('trace_id')->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
