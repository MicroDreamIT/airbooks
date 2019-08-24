<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->enum('type',['aircraft', 'engine', 'apu', 'parts', 'news', 'event'])->index(); //Type like Aircraft, Apu etc
            $table->string('name'); // Category Name
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
//            $table->unique(['type', 'name']);
        });





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');

    }
}
