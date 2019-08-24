<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturers', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['aircraft', 'engine', 'apu', 'parts'])->index(); //Type like Aircraft, Apu etc
            $table->string('name');
            $table->string('established')->nullable();
            $table->integer('country_id')->unsigned()->index()->nullable();
            $table->boolean('is_active');
            $table->text('description')->nullable();
//            $table->unique(['type', 'name']);
            $table->timestamps();
        });
        Schema::create('category_manufacturer', function (Blueprint $table) {
            $table->integer('manufacturer_id')->index()->unsigned();
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade');
            $table->integer('category_id')->index()->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });



        // There is a Media Need to Put on media table



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manufacturers');


    }
}
