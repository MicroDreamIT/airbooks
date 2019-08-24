<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index(); //done
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('entity_type',['aircraft','engine','apu']);
            $table->string('category')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('type')->nullable();
            $table->string('model')->nullable();
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
        Schema::dropIfExists('suggestions');
    }
}
