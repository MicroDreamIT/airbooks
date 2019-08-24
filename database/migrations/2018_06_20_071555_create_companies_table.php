<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //Company Name
            $table->boolean('status')->default(false); //Flag Active or Non-active
            $table->text('profile')->nullable(); //Max 1000 words
            $table->string('zip_code')->nullable();
            $table->string('po_box')->nullable();
            $table->string('business_phone')->nullable();
            $table->text('address')->nullable();
            $table->integer('city_id')->index()->unsigned()->nullable();
            $table->integer('state_id')->index()->unsigned()->nullable();
            $table->integer('country_id')->index()->unsigned()->nullable();
            $table->text('logo')->nullable();
            $table->text('website')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_published')->default(false);
            $table->integer('views')->default(0);
            $table->string('rfq_email')->nullable();
            $table->string('aog_email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('company_speciality', function (Blueprint $table) {
            $table->integer('company_id')->index()->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->integer('speciality_id')->index()->unsigned();
            $table->foreign('speciality_id')->references('id')->on('specialities')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_speciality');
    }
}
