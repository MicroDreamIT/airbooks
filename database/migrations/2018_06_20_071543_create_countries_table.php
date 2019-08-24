<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name'); //Country Name
            $table->integer('continent_id')->index()->unsigned();
            $table->foreign('continent_id')->references('id')->on('continents')->onDelete('cascade');
            $table->integer('region_id')->index()->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->string('capital')->nullable(); // usd, gbp etc
            $table->string('currency')->nullable(); // usd, gbp etc
            $table->string('iso_3116_alpha_2')->nullable();
            $table->string('dialing_code')->nullable(); // +1, +88 etc
            $table->text('flag')->nullable(); // SVG Icon
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('countries');
    }
}
