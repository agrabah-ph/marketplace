<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('model_id')->nullable();
            $table->string('model_type')->nullable();

            // borrower profile
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('gender')->nullable();
            $table->string('landline')->nullable();
            $table->string('mobile')->nullable();
            $table->string('tin')->nullable();
            $table->string('sss_gsis')->nullable();
            $table->string('education')->nullable();
            $table->text('secondary_info')->nullable();
            $table->text('spouse_comaker_info')->nullable();
            $table->text('farming_info')->nullable();
            $table->text('employment_info')->nullable();
            $table->text('income_asset_info')->nullable();
            $table->string('qr_image')->nullable();
            $table->string('qr_image_path')->nullable();
            $table->string('status')->nullable();
            $table->string('designation')->nullable();

            // loan provider profile
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->nullable();
            $table->text('branch_address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_designation')->nullable();
            $table->string('contact_number')->nullable();


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
        Schema::dropIfExists('profiles');
    }
}
