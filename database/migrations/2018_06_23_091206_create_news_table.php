<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index(); //News Title
            $table->string('date')->nullable(); //News Title
            $table->integer('company_id')->index()->unsigned()->nullable();
            $table->integer('continent_id')->index()->unsigned();
            $table->foreign('continent_id')->references('id')->on('continents')->onDelete('cascade');
            $table->integer('region_id')->index()->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->integer('country_id')->index()->unsigned()->nullable();
            $table->text('source')->nullable();
            $table->longText('details')->nullable(); // News Text
            $table->boolean('is_active')->default(true);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
        Schema::create('category_news', function (Blueprint $table) {
            $table->integer('news_id')->index()->unsigned();
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');

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
        Schema::dropIfExists('news');
        Schema::dropIfExists('category_news');
    }
}
