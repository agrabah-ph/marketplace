<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('borrower_id')->nullable();
            $table->string('borrower_type')->nullable();
            $table->integer('loan_provider_id');
            $table->integer('loan_product_id');
            $table->enum('status', array('Pending', 'Active', 'Completed', 'Declined', 'Cancelled'));
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('penalty')->nullable();
            $table->boolean('accept')->default(0);
            $table->double('amount')->nullable();
            $table->integer('duration')->nullable();
            $table->double('interest_rate')->nullable();
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
        Schema::dropIfExists('loans');
    }
}
