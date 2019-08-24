<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //Airport Name
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('city_id')->nullable();
//            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->integer('country_id')->index()->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->integer('state_id')->index()->unsigned();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->string('iata_code')->nullable();
            $table->string('icao_code')->nullable();
            $table->integer('airfield_type_id')->index()->unsigned();
            $table->foreign('airfield_type_id')->references('id')->on('airfield_types')->onDelete('cascade');
            $table->string('time_zone')->nullable(); //+6, +5 etc
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('sunrise')->nullable();
            $table->string('sunset')->nullable();
            $table->integer('views')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_published')->default(false);
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
        Schema::dropIfExists('airports');
    }
}
