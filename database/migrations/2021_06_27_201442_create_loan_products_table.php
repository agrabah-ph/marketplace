<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_provider_id');
            $table->unsignedBigInteger('loan_type_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->double('amount');
            $table->integer('duration');
            $table->double('interest_rate');
            $table->string('timing')->default('monthly')->nullable();
            $table->integer('allowance')->default(1);
            $table->integer('first_allowance')->default(0);
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
        Schema::dropIfExists('loan_products');
    }
}
