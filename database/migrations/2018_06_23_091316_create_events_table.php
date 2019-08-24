<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->integer('continent_id')->index()->unsigned();
            $table->foreign('continent_id')->references('id')->on('continents')->onDelete('cascade');
            $table->integer('region_id')->index()->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->integer('country_id')->index()->unsigned()->nullable();
            $table->integer('state_id')->index()->unsigned()->nullable();
            $table->integer('city_id')->index()->unsigned()->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->longText('details')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('views');
            $table->timestamps();
        });
        Schema::create('category_event', function (Blueprint $table) {
            $table->integer('event_id')->index()->unsigned();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            $table->integer('category_id')->index()->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
